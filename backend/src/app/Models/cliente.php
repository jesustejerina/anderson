<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $fillable = [
        'nombres',
        'apellidos',
        'email',
        'total_pagos',
        'user_id',
        'activo',
    ];

    public function pagos()
    {
        return $this->hasMany(pago::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
