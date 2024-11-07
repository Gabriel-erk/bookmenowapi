<?php

use App\Http\Controllers\Api\CategoriaApiController;
use App\Http\Controllers\Api\ServicoApiController;
use App\Http\Controllers\Api\UsuarioApiController;
use Illuminate\Support\Facades\Route;

Route::controller(CategoriaApiController::class)->group(function () {
    Route::get("categorias", 'index');
    Route::post("categorias/salvar", 'store');
    Route::put("categorias/atualizar/{id}", 'update');
    Route::put("categorias/visualizar/{id}", 'show');
    Route::delete("categorias/deletar/{id}", 'destroy');
});

Route::controller(ServicoApiController::class)->group(function () {
    Route::get("servicos", 'index');
    Route::get("servicos/visualizar/{id}", 'show');
    Route::post("servicos/salvar", 'store');
    Route::put("servicos/atualizar/{id}", 'update');
    Route::delete("servicos/deletar/{id}", 'destroy');
});

Route::controller(UsuarioApiController::class)->group(function () {
    Route::get("usuarios", 'index');
    Route::get("usuarios/visualizar/{id}", 'show');
    Route::post("usuarios/salvar", 'store');
    Route::put("usuarios/atualizar/{id}", 'update');
    Route::delete("usuarios/deletar/{id}", 'destroy');
});