<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColaController extends Controller
{
    public function uploadFiles(Request $request)
    {
        $request->validate([
            'files.*' => 'required|mimes:jpg,jpeg,png,bmp|max:2048',
        ]);

        $uploadedFiles = [];
        $failedFiles = [];

        if ($request->hasfile('files')) {
            foreach ($request->file('files') as $file) {
                try {
                    $filename = $file->getClientOriginalName();
                    $file->move(public_path('pictures'), $filename);
                    $uploadedFiles[] = $filename;
                } catch (\Exception $e) {
                    $failedFiles[] = $filename;
                }
            }
        }

        // if (count($failedFiles) > 0) {
        //     // Aquí podrías guardar los archivos fallidos en una cola para reintento
        //     // y moverlos a una carpeta temporal
        //     foreach ($failedFiles as $failedFile) {
        //         $file->move(storage_path('app/temporary'), $failedFile);
        //     }
        // }

        return response()->json([
            'message' => 'Files uploaded successfully',
            'files' => $uploadedFiles,
            'failed' => $failedFiles,
        ]);
    }
    
}
