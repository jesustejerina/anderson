<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//Rutas Privadas:
Route::middleware('auth:sanctum')->group(function (){
    
    Route::controller(AuthController::class)->group(function(){
        //Route::post('/registrar', 'registrar')->name('registrar');
        Route::get('/esta-autenticado','autenticado')->name('autenticado');
        Route::post('/logout', 'logout')->name('logout');
        Route::get('/get-user-info','getInfoUser')->name('get-user-info');
        Route::get('dame-usuarios','getUsers')->name('dame-usuarios');
        Route::get('activar-usuario/{iduser}','activeUser')->name('activar-usuario');
        Route::get('borrar-usuario/{iduser}','borrarUsuario')->name('borrar-usuario');
    });



});

//Rutas públicas:
Route::post('login' ,[AuthController::class , 'login'])->name('login');
Route::get('/register', [AuthController::class,'register'])->name('register'); //temporal
Route::post('/registrar', [AuthController::class,'registrar'])->name('registrar'); //temporal