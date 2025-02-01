<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SessionRevocationController extends Controller
{
    public function revoke(Request $request, $sessionId)
    {
        // Verificar que el enlace tenga una firma válida
        if (!$request->hasValidSignature()) {
            abort(403, 'Enlace no válido o expirado');
        }

        // Eliminar la sesión de la base de datos
        DB::table('sessions')->where('id', $sessionId)->delete();

        // Retornar una respuesta en formato JSON
        return response()->json(['message' => 'La sesión ha sido cerrada correctamente']);
    }
}
