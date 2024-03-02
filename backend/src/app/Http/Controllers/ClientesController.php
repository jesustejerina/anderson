<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgregarClienteRequest;
use App\Http\Resources\ClienteResource;
use App\Models\cliente;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ClientesController extends Controller
{

    public function agregarCliente(AgregarClienteRequest $r)
    {
        try {
            $user_id = Auth::user()->id;
            $cliente = new cliente();
            $cliente->nombres = $r->nombres;
            $cliente->apellidos = $r->apellidos;
            $cliente->email = $r->email;
            $cliente->total_pagos = 0.0;
            $cliente->user_id = $user_id;
            $cliente->activo = 1;
            $cliente->save();
            $elcliente = new ClienteResource($cliente);
            return response()->json([
                'status' => 'OK',
                'message' => 'Cliente agregado',
                'cliente' => $elcliente,
            ])->setStatusCode(200, 'Cliente agregado');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'No se pudo agregar el cliente',
                'error' => $e->getMessage(),
            ])->setStatusCode(401, 'No se pudo agregar el cliente');
        }
    }

    public function actualizarCliente(AgregarClienteRequest $r)
    {
        try {
            $cliente = cliente::find($r->id)
                ->update([
                    'nombres' => $r->nombres,
                    'apellidos' => $r->apellidos,
                    'email' => $r->email,
                ]);
            return response()->json([
                'status' => 'OK',
                'message' => 'Cliente Actualizado',
            ])->setStatusCode(200, 'Cliente Actualizado');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'No se pudo ACTUALIZAR el cliente',
                'error' => $e->getMessage(),
            ])->setStatusCode(401, 'No se pudo ACTUALIZAR el cliente');
        }
    }

    public function borrarCliente($cliente_id)
    {
        try {
            cliente::find($cliente_id)->delete();
            return response()->json([
                'status' => 'OK',
                'message' => 'Cliente Borrado incluido sus pagos.',
            ])->setStatusCode(200, 'Cliente Borrado incluido sus pagos');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'No se pudo borrar el cliente',
                'error' => $e->getMessage(),
            ])->setStatusCode(401, 'No se pudo borrar el cliente');
        }
    }

    public function dameCliente($cliente_id)
    {
        try {
            $cliente = cliente::find($cliente_id);
            $elcliente = new ClienteResource($cliente);
            return response()->json([
                'status' => 'OK',
                'message' => 'Cliente entregado',
                'cliente' => $elcliente,
            ])->setStatusCode(200, 'Cliente entregado');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'No se pudo entregar el cliente',
                'error' => $e->getMessage(),
            ])->setStatusCode(401, 'No se pudo entregar el cliente');
        }
    }

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
