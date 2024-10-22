<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servico;
use Exception;

class ServicoApiController extends Controller
{
    public function index()
    {
        try {
            $servicos = Servico::all();
            return response()->json([$servicos], 200);
        } catch (Exception $e) {
            return response()->json(["Erro" => "Erro ao listar dados"], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $servico = Servico::findOrFail($id);
            return response()->json([$servico], 200);
        } catch (\Throwable $th) {
            return response()->json(["Erro"=> "Não foi possivel encontrar o serviço"]);
        }
    }
}
