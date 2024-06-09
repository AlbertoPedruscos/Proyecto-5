<?php
namespace App\Http\Controllers;

use App\Models\tbl_plazas;
use App\Models\tbl_parking;
use App\Models\tbl_estados;
use App\Models\tbl_empresas;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class MapaGestorController extends Controller
{
    /* Función para mostrar los parkings en el mapa */
    public function index(Request $request)
    {
        // Obtén la empresa del usuario actual
        $idEmpresa = $request->session()->get('empresa');
        
        // Obtén los parkings que pertenecen a esta empresa
        $parkings = tbl_parking::with(['plazas', 'empresa'])
            ->where('id_empresa', $idEmpresa)
            ->get();
            
        $plazas = tbl_plazas::all();
        $estados = tbl_estados::all();
        $empresas = tbl_empresas::all();
    
        return view('gestion.mapa', compact('parkings', 'plazas', 'estados', 'empresas'));
    }
    
    public function store(Request $request) 
    {
        // Validación de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'capacidad' => 'required|numeric',
            'empresa_id' => 'required|exists:tbl_empresas,id',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'latitud.required' => 'La latitud es obligatoria.',
            'longitud.required' => 'La longitud es obligatoria.',
            'capacidad.required' => 'La capacidad es obligatoria.',
            'empresa_id.required' => 'La empresa es obligatoria.',
            'empresa_id.exists' => 'La empresa no existe en la base de datos.',
        ]);

        // Iniciar una transacción
        DB::beginTransaction();

        try {
            // Verificar duplicados basados en el nombre y la empresa
            $nombre = $validatedData['nombre'];
            $empresa_id = $validatedData['empresa_id'];

            // Verificar si el parking con el mismo nombre ya existe en la misma empresa
            $parkingExists = tbl_parking::where('nombre', $nombre)
                ->where('id_empresa', $empresa_id)
                ->exists();

            if ($parkingExists) {
                // Devuelve un error si ya existe un parking con ese nombre en esa empresa
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'El nombre del parking ya está registrado para esta empresa.');
            }

            // Crear el nuevo parking
            $parking = new tbl_parking();
            $parking->nombre = $nombre;
            $parking->latitud = $validatedData['latitud'];
            $parking->longitud = $validatedData['longitud'];
            $parking->capacidad = $validatedData['capacidad'];
            $parking->id_empresa = $empresa_id;

            // Guardar el nuevo parking
            $parking->save();

            // Insertar las plazas de parking
            $capacidad = $validatedData['capacidad'];
            for ($i = 1; $i <= $capacidad; $i++) {
                $plaza = new tbl_plazas();
                $plaza->nombre = 'Plaza ' . $i;
                $plaza->planta = 1;
                $plaza->id_estado = 2;
                $plaza->id_parking = $parking->id;
                $plaza->save();
            }

            // Commit de la transacción
            DB::commit();

            return redirect()->route('mapa')->with('success', 'Parking registrado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, hacer rollback de la transacción
            DB::rollBack();
            return redirect()->route('mapa')->with('error', 'Error al registrar el parking: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Buscar y eliminar el parking por su ID
            $parking = tbl_parking::findOrFail($id);
            $parking->delete();
            return redirect()->route('mapa')->with('success', 'Parking eliminado exitosamente.');
        } 
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el parking: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id) {
        try {
            $parking = tbl_parking::with(['empresa'])->findOrFail($id);
            return response()->json($parking);
        } 
        catch (\Exception $e) {
            return response()->json(['error' => 'Parking not found'], 404);
        }
    }    

    public function update(Request $request, $id) {
        // Validación de campos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'capacidad' => 'required|numeric',
            'empresa' => 'required|exists:tbl_empresas,id',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'latitud.required' => 'La latitud es obligatoria.',
            'longitud.required' => 'La longitud es obligatoria.',
            'capacidad.required' => 'La capacidad es obligatoria.',
            'empresa.required' => 'La empresa es obligatoria.',
        ]);
    
        // Iniciar una transacción
        DB::beginTransaction();
    
        try {
            // Buscar y actualizar el parking
            $parking = tbl_parking::findOrFail($id);
            $parking->nombre = $request->nombre;
            $parking->latitud = $request->latitud;
            $parking->longitud = $request->longitud;
            $parking->capacidad = $request->capacidad;
            $parking->id_empresa = $request->empresa;
    
            // Guardar los cambios en el parking
            $parking->save();
    
            // Eliminar las plazas de aparcamiento asociadas al parking
            tbl_plazas::where('id_parking', $id)->delete();
    
            // Crear nuevas plazas de aparcamiento según la capacidad recibida
            $capacidad = $request->capacidad;
            for ($i = 1; $i <= $capacidad; $i++) {
                $plaza = new tbl_plazas();
                $plaza->nombre = 'Plaza ' . $i;
                $plaza->planta = 1;
                $plaza->id_estado = 2;
                $plaza->id_parking = $parking->id;
                $plaza->save();
            }
    
            // Commit de la transacción
            DB::commit();
    
            return redirect()->route('mapa')->with('success', 'Parking actualizado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, hacer rollback de la transacción
            DB::rollBack();
            return redirect()->route('mapa')->with('error', 'Error al actualizar el parking: ' . $e->getMessage());
        }
    }
        
    public function filtrarParkings(Request $request) {
        $nombre = $request->get("nombre");
        $empresa = $request->get("empresa");
    
        $query = tbl_parking::query();
    
        if ($nombre) {
            $query->where("nombre", "LIKE", "%{$nombre}%");
        }
    
        if ($empresa) {
            $query->where("id_empresa", $empresa);
        }
    
        $parkings = $query->get();
    
        return response()->json([
            "parkings" => $parkings,
        ]);
    }

    public function updateLocation(Request $request, $id)
    {
        // Encuentra el parking por ID
        $parking = tbl_parking::find($id);

        // Verifica si el parking existe
        if (!$parking) {
            return Response::json([
                'success' => false,
                'message' => 'Parking no encontrado.',
            ], 404);
        }

        // Valida los datos de entrada
        $validated = $request->validate([
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
        ]);

        // Actualiza las coordenadas del parking
        $parking->latitud = $validated['latitud'];
        $parking->longitud = $validated['longitud'];

        try {
            // Guarda los cambios en la base de datos
            $parking->save();

            return Response::json([
                'success' => true,
                'message' => 'Ubicación actualizada con éxito.',
            ]);
        } 
        
        catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'Error al guardar los cambios.',
            ], 500);
        }
    }

    public function showPlazas(Request $request)
    {
        $parkingId = $request->query('parking');
        
        // Obtener el parking por su ID
        $parking = tbl_parking::find($parkingId);
        
        if (!$parking) {
            // Si no se encuentra el parking, redirigir a una página de error o gestionar como sea necesario
            abort(404);
        }
    
        $idEmpresa = $request->session()->get('empresa');
    
        // Almacenar el ID del parking en la sesión
        Session::put('id_parking', $parkingId);
        
        // Obtener las plazas de parking para el parking específico
        $plazas = tbl_plazas::where('id_parking', $parkingId)->get();
        
        // Almacenar las plazas en la sesión
        Session::put('plazas', $plazas);
        
        // Pasar los datos del parking y las plazas a la vista
        return view('/gestion.plazasParking', compact('parking', 'plazas'));
    }

    public function exportarCSV()
    {
        $now = now();
        $date = $now->toDateString();
        $time = $now->toTimeString();
    
        $parkings = tbl_parking::with(['empresa', 'plazas.estado'])->get();
    
        $csvContent = [];
    
        // Encabezados del CSV
        $csvContent[] = ['Parking', 'Empresa', 'Plaza', 'Estado', 'Fecha', 'Hora'];
    
        foreach ($parkings as $parking) {
            foreach ($parking->plazas as $plaza) {
                $csvContent[] = [
                    str_replace(' ', '_', $parking->nombre),
                    $parking->empresa ? str_replace(' ', '_', $parking->empresa->nombre) : 'Sin_Empresa',
                    str_replace(' ', '_', $plaza->nombre),
                    $plaza->estado ? str_replace(' ', '_', $plaza->estado->nombre) : 'Sin_Estado',
                    $date, // Fecha actual
                    $time, // Hora actual
                ];
            }
        }
    
        $empresaNombre = $parkings->first()->empresa ? str_replace(' ', '_', $parkings->first()->empresa->nombre) : 'Sin_Empresa';
        $filename = "{$empresaNombre}_parkings_{$date}_{$time}.csv";
    
        // Abrir un buffer de salida en lugar de php://output
        $handle = fopen('php://temp', 'r+');
    
        foreach ($csvContent as $row) {
            fputcsv($handle, $row);
        }
    
        // Rebobinar el buffer para leer su contenido
        rewind($handle);
    
        // Obtener el contenido del buffer
        $csvOutput = stream_get_contents($handle);
    
        // Cerrar el buffer
        fclose($handle);
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
    
        return response($csvOutput, 200, $headers);
    }
}
