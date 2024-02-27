<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgregarPagoRequest;
use App\Http\Resources\PagoResource;
use App\Models\cliente;
use App\Models\pago;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PagosController extends Controller
{
    public function agregarPago(AgregarPagoRequest $r)
    {
        try {
            $user_id = Auth::user()->id;
            $pago = new pago();
            $pago->forma_pago = $r->forma;
            $pago->detalle = $r->detalle;
            $pago->monto = $r->monto;
            $pago->cliente_id = $r->cliente_id;
            $pago->user_id = $user_id;
            $pago->activo = 1;
            $pago->save();
            $elpago = new PagoResource($pago);
            $this->recalcularTotalPagos($r->cliente_id);
            return response()->json([
                'status' => 'OK',
                'message' => 'Pago agregado',
                'pago' => $elpago,
            ])->setStatusCode(200, 'Pago agregado');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'No se pudo agregar el pago',
                'error' => $e->getMessage(),
            ])->setStatusCode(401, 'No se pudo agregar el pago');
        }
    }

    private function recalcularTotalPagos($cliente_id)
    {
        try {
            $total_pagos = pago::where('cliente_id', $cliente_id)->sum('monto');
            $cliente = cliente::find($cliente_id);
            $cliente->total_pagos = $total_pagos;
            $cliente->save();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'No se pudo recalcular el total de pagos',
                'error' => $e->getMessage(),
            ])->setStatusCode(401, 'No se pudo recalcular el total de pagos');
        }

    }

    public function damePagos($cliente_id)
    {
        $pagos = pago::where('cliente_id', $cliente_id)->get();
        if ($pagos->count() > 0) {
            $losPagos = PagoResource::collection($pagos);
            return response()->json([
                'status' => 'OK',
                'message' => 'Listado de Pagos del cliente',
                'pagos' => $losPagos,
            ])->setStatusCode(200, 'Listado de Pagos del cliente');
        } else {
            return response()->json([
                'status' => 'CUIDADO',
                'message' => 'No hay pagos para el cliente seleccionado',
            ])->setStatusCode(200, 'No hay pagos para el cliente seleccionado');
        }
    }
}
