<?php

use App\Http\Controllers\Api\CategoriaApiController;
use App\Http\Controllers\Api\ServicoApiController;
use Illuminate\Support\Facades\Route;

Route::get("categorias",[CategoriaApiController::class, 'index']);
Route::get("categorias/visualizar/{id}",[CategoriaApiController::class, 'show']);

Route::get("servicos",[ServicoApiController::class, 'index']);
Route::get("servicos/visualizar/{id}",[ServicoApiController::class, 'show']);

