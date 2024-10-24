<?php

use App\Http\Controllers\Api\CategoriaApiController;
use App\Http\Controllers\Api\ServicoApiController;
use Illuminate\Support\Facades\Route;

Route::controller(CategoriaApiController::class)->group(function (){
    Route::get("categorias", 'index');
    Route::post("categorias/salvar", 'store');
    Route::put("categorias/atualizar/{id}", 'update');
    Route::put("categorias/visualizar/{id}", 'show');
    Route::delete("categorias/deletar/{id}", 'destroy');
});

Route::get("servicos",[ServicoApiController::class, 'index']);
Route::get("servicos/visualizar/{id}",[ServicoApiController::class, 'show']);
Route::get("servicos/salvar",[ServicoApiController::class, 'store']);
Route::get("servicos/atualizar/{id}",[ServicoApiController::class, 'update']);