<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use Exception;

class CategoriaApiController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        try {
            // aqui estamos abrindo uma porta de api - retornando uma resposta em formato de json (ao invés de uma view), e agora podemos consumir essas informações
            // está listando todas as informações de cada registro de categorias
            // todo código com inicio em '2' é sucesso, por isso coloquei 200 ao lado da minha váriavel
            return response()->json($categorias, 200);
        } catch (Exception $e) {
            // todo código com inicio em '5' é erro, por isso coloquei 500 ao lado da minha váriavel
            return response()->json(["Erro" => "Erro ao listar os dados"], 500);
        }
    }

    // econtrar uma categoria só
    public function show(string $id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            return response()->json($categoria, 200);
        } catch (Exception $e) {
            // erro 404 de eregistro não foi encontrado
            return response()->json(["Erro" => "Categoria não encontrada"], 404);
        }
    }
}
