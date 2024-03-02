<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pago extends Model
{
    use HasFactory;
    protected $table = 'pagos';
    protected $fillable = [
        'forma_pago',
        'detalle',
        'monto',
        'user_id',
        'cliente_id',
        'activo',
    ];

    public function cliente()
    {
        return $this->belongsTo(cliente::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

}
