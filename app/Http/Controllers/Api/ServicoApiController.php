<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servico;
use App\Models\Foto;
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
            return response()->json(["Erro" => "Não foi possivel encontrar o serviço"]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:100',
            'descricao' => 'required',
            'valor' => 'required|numeric',
            'celular' => 'required|string|max:20',
            'endereco' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'cep' => 'required',
            'usuario_id' => 'required',
            'categoria_id' => 'required'

        ]);

        try {
            $servico = Servico::create($request->all());

            if ($request->hasFile('foto')) {
                foreach ($request->file('foto') as $file) {
                    $caminhoFoto = $file->store('fotos', 'public');
                    Foto::create([
                        'servico_id' => $servico->id,
                        'imagem' => $caminhoFoto
                    ]);
                }
            }
            return response()->json($servico, 200);
        } catch (Exception $e) {
            return response()->json(["Erro" => "Não foi possivel salvar o serviço"]);
        }
    }
}
