<?php

namespace App\Http\Controllers;

use App\Models\tbl_chat;
use App\Models\tbl_usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;


class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'id' => 'required',
            // Añade más reglas de validación según tus necesidades
        ]);
        $id_user = 1;
        $mensajes = tbl_chat::where('id', '>', $request->id)->get();
        $htmlMensajes = '';
        foreach ($mensajes as $mensaje) {
            // Condición para determinar la clase CSS del mensaje según el emisor
            if ($mensaje->emisor == $id_user) {
                $htmlMensajes .= '<div class="chatEmi">';
                $htmlMensajes .= '<input type="hidden" name="mensaje_id" value="' . $mensaje->id . '">';
                $htmlMensajes .= '<p>' . $mensaje->mensaje . '</p>';
                $htmlMensajes .= '</div>';
                $htmlMensajes .= '<br>';
            } else {
                $usus = tbl_usuarios::where('id', $mensaje->emisor)->get();
                foreach ($usus as $usu) {}
                $htmlMensajes .= '<div class="chatRec">';
                $htmlMensajes .= '<h2>' . $usu->nombre . '</h2>';
                $htmlMensajes .= '<input type="hidden" name="mensaje_id" value="' . $mensaje->id . '">';
                $htmlMensajes .= '<p>' . $mensaje->mensaje . '</p>';
                $htmlMensajes .= '</div>';
                $htmlMensajes .= '<br>';
            }
        }
        if ($htmlMensajes!=''){
            return $htmlMensajes;
        }
    }

    public function chat2()
    {
        $id_user = 1;
        $mensajes = tbl_chat::all();
        $htmlMensajes = '';
        foreach ($mensajes as $mensaje) {
            // Condición para determinar la clase CSS del mensaje según el emisor
            if ($mensaje->emisor == $id_user) {
                $htmlMensajes .= '<div class="chatEmi">';
                $htmlMensajes .= '<input type="hidden" name="mensaje_id" value="' . $mensaje->id . '">';
                $htmlMensajes .= '<p>' . $mensaje->mensaje . '</p>';
                $htmlMensajes .= '</div>';
                $htmlMensajes .= '<br>';
            } else {
                $usus = tbl_usuarios::where('id', $mensaje->emisor)->get();
                foreach ($usus as $usu) {}
                $htmlMensajes .= '<div class="chatRec">';
                $htmlMensajes .= '<h2>' . $usu->nombre . '</h2>';
                $htmlMensajes .= '<input type="hidden" name="mensaje_id" value="' . $mensaje->id . '">';
                $htmlMensajes .= '<p>' . $mensaje->mensaje . '</p>';
                $htmlMensajes .= '</div>';
                $htmlMensajes .= '<br>';
            }
        }
        if ($htmlMensajes!=''){
            return $htmlMensajes;
        }
    }

    public function enviarMen(Request $request){
        // Obtener el ID del emisor de la sesión
        $emisor = /* Session::get('id_user') */ 1;
        // Obtener el ID del receptor del formulario (supongo que está llegando a través de una solicitud)
        $receptor = 2 /* $request->input('receptor') */;
        // Suponiendo que los datos del formulario llegan mediante un Request
        $mensaje = $request->input('mensaje');
    
        // Crear un nuevo mensaje en el modelo TblChat
        $mensajeNuevo = new tbl_chat();
        $mensajeNuevo->emisor = $emisor;
        $mensajeNuevo->receptor = $receptor;
        $mensajeNuevo->mensaje = $mensaje;
        $mensajeNuevo->save();
    }
}
