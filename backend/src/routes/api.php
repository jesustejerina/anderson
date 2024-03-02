<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\PagosController;
use Illuminate\Support\Facades\Route;

//Rutas Privadas:
Route::middleware('auth:sanctum')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        //Route::post('/registrar', 'registrar')->name('registrar');
        Route::get('/esta-autenticado', 'autenticado')->name('autenticado');
        Route::post('/logout', 'logout')->name('logout');
        Route::get('/get-user-info', 'getInfoUser')->name('get-user-info');
        Route::get('dame-usuarios', 'getUsers')->name('dame-usuarios');
        Route::get('activar-usuario/{iduser}', 'activeUser')->name('activar-usuario');
        Route::get('borrar-usuario/{iduser}', 'borrarUsuario')->name('borrar-usuario');
    });

    Route::controller(ClientesController::class)->group(function () {
        Route::get('/dame-clientes', 'dameClientes')->name('dame-clientes');
        Route::get('/dame-cliente/{id}', 'dameCliente')->name('dame-cliente');
        Route::post('/agregar-cliente', 'agregarCliente')->name('agregar-cliente');
        Route::delete('/borrar-cliente/{id}', 'borrarCliente')->name('borrar-cliente');
        Route::patch('/actualizar-cliente', 'actualizarCliente')->name('actualizar-cliente');
    });

    Route::controller(PagosController::class)->group(function () {
        Route::get('/dame-pagos/{id}', 'damePagos')->name('dame-pagos');
        Route::post('/agregar-pago', 'agregarPago')->name('agregar-pago');
        Route::delete('/borrar-pago/{id}', 'borrarPago')->name('borrar-pago');
        Route::patch('/actualizar-pago', 'actualizarPago')->name('actualizar-pago');
    });

});

//Rutas públicas:
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register'); //temporal
Route::post('/registrar', [AuthController::class, 'registrar'])->name('registrar'); //temporal
