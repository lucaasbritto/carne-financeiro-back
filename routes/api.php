<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarneController;


Route::post('/criar-carne', [CarneController::class, 'criarCarne']);
Route::get('/recuperar-parcelas/{id}', [CarneController::class, 'recuperarParcelas']);