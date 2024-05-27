<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_fotos;

class ColaController extends Controller
{
    public function uploadFiles(Request $request)
    {
        // Validación de archivos
        $request->validate([
            'files.*' => 'required|mimes:jpg,jpeg,png,bmp|max:2048',
        ]);

        $uploadedFiles = [];
        $failedFiles = [];

        if ($request->hasfile('files')) {
            foreach ($request->file('files') as $file) {
                try {
                    // Obtener nombre del archivo original
                    $originalFilename = $file->getClientOriginalName();

                    // Extraer id_reserva del nombre del archivo
                    $id_reserva = $this->extractIdReserva($originalFilename);

                    // Generar un nombre de archivo único
                    $uniqueFilename = $this->generateUniqueFilename($originalFilename, $id_reserva);

                    // Mover archivo a la carpeta pública con el nombre único
                    $file->move(public_path('pictures'), $uniqueFilename);

                    // Insertar en la tabla tbl_fotos
                    tbl_fotos::create([
                        'id_reserva' => $id_reserva,
                        'ruta' => $uniqueFilename,
                    ]);

                    $uploadedFiles[] = $uniqueFilename;
                } catch (\Exception $e) {
                    $failedFiles[] = $originalFilename;
                }
            }
        }

        return response()->json([
            'message' => 'Files uploaded successfully',
            'files' => $uploadedFiles,
            'failed' => $failedFiles,
        ]);
    }

    // Método para extraer id_reserva del nombre del archivo
    private function extractIdReserva($filename)
    {
        $parts = explode('_', $filename);
        return (int)$parts[0];  // Convertir el primer segmento a entero
    }

    // Método para generar un nombre de archivo único
    private function generateUniqueFilename($originalFilename, $id_reserva)
    {
        $pathInfo = pathinfo($originalFilename);
        $filenameWithoutExtension = $pathInfo['filename'];
        $extension = $pathInfo['extension'];

        $parts = explode('_', $filenameWithoutExtension);
        $lastNumber = (int)end($parts);

        // Generar nuevo nombre si existe duplicado
        while (!$this->isUniqueRoute($id_reserva, $lastNumber)) {
            $lastNumber++;
            $parts[count($parts) - 1] = $lastNumber;
            $filenameWithoutExtension = implode('_', $parts);
        }

        return $filenameWithoutExtension . '.' . $extension;
    }

    // Método para verificar si la ruta es única para el mismo id_reserva
    private function isUniqueRoute($id_reserva, $lastNumber)
    {
        $existingFotos = tbl_fotos::where('id_reserva', $id_reserva)->get();

        foreach ($existingFotos as $foto) {
            $existingFilename = pathinfo($foto->ruta, PATHINFO_FILENAME);
            $existingLastNumber = $this->extractLastNumber($existingFilename);

            if ($existingLastNumber === $lastNumber) {
                return false;  // Si encontramos un número igual, no es único
            }
        }

        return true;  // No se encontraron duplicados
    }

    // Método para extraer el último número del nombre del archivo (sin extensión)
    private function extractLastNumber($filename)
    {
        $parts = explode('_', $filename);
        return (int)end($parts);  // Convertir el último segmento a entero
    }
}
