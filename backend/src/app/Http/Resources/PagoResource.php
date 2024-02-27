<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PagoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'forma_pago' => $this->forma_pago,
            'detalle' => $this->detalle,
            'monto' => $this->monto,
            'cliente_id' => $this->cliente_id,
        ];
    }
}
