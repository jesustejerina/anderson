<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClienteResource;
use App\Models\cliente;

class ClientesController extends Controller
{
    public function dameClientes()
    {
        try {
            $clientes_collection = cliente::all();
            $clientes = ClienteResource::collection($clientes_collection);
            return response()->json([
                'status' => 'OK',
                'message' => 'Listado de Clientes',
                'clientes' => $clientes,
            ])->setStatusCode(200, 'Listado de Clientes');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'No se obtuvo los clientes',
                'error' => $e->getMessage(),
            ])->setStatusCode(401, 'No se obtuvo los clientes');
        }

    }
}
