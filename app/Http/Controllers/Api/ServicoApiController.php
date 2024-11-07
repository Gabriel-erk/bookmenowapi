<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servico;
use App\Models\Foto;
use Exception;
use Illuminate\Support\Facades\Storage;

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
        } catch (\Exception $e) {
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

    public function update(Request $request, string $id)
    {
        // Validação dos dados
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
            $servico = Servico::findOrFail($id);

            $servico->update($request->all());

            if ($request->hasFile('foto')) {

                foreach ($servico->fotos as $foto) {
                    Storage::disk('public')->delete($foto->imagem);
                    $foto->delete();
                }

                foreach ($request->file('foto') as $file) {
                    $caminhoFoto = "/storage/" . $file->store('fotos', 'public');
                    Foto::create([
                        'servico_id' => $servico->id,
                        'imagem' => $caminhoFoto
                    ]);
                }
            }
            return response()->json($servico, 200);
        } catch (Exception $e) {
            // return response()->json(["Erro" => "Erro ao atualizar serviço"], 500);
            // $e->getMessage() para retornar os detalhes do erro ($e é a váriavel do tipo exception e getMessage apenas mostra no terminal de onde estiver pegando o json as info do erro q estou tendo)
            return response()->json(["Erro" => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $servico = Servico::findOrFail($id);
            foreach ($servico->fotos as $foto) {
                Storage::disk('public')->delete($foto->imagem);
                $foto->delete();
            }
            $servico->delete();
            return response()->json(["message" => "Serviço deletada com sucesso"], 200);
        } catch (Exception $e) {
            return response()->json(["Erro" => "Erro ao deletar serviço"], 500);
        }
    }

}