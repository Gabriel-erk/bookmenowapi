<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Foto;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicoApiController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $servicos = Servico::with('fotos')->get();
    // map vai percorrer servicos e jogar na váriavel servico (parâmetro da funcção anonima, dentro do map)
    $servicos = $servicos->map(function ($servico){
      // asset($servico->fotos[0]->imagem), encontra essa informação e joga dentro de $servico->fotos[0]->imagem =
      // ou seja, o campo imagem, dentro de fotos na posição 0 dentro da váriavel servico que é uma instância da tabela servicos, irá receber o caminho BRUTO da imagem (ou seja, por ex: "imagem": "http://10.56.45.27/public/img/categoria-informatica.jpg",) 
      $servico->fotos[0]->imagem = asset($servico->fotos[0]->imagem);
      return $servico;
    });
    
    return response()->json($servicos);
  }

  /**
   * Store a newly created resource in storage.
   */
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

    return response()->json(['message' => 'Cadastro realizado com sucesso!', 'servico' => $servico], 201);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $servico = Servico::with('fotos')->findOrFail($id);
    return response()->json($servico);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
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

    $servico = Servico::findOrFail($id);
    $servico->update($request->all());

    if ($request->hasFile('foto')) {
      foreach ($servico->fotos as $foto) {
        Storage::disk('public')->delete($foto->imagem);
        $foto->delete();
      }

      foreach ($request->file('foto') as $file) {
        $caminhoFoto = $file->store('fotos', 'public');
        Foto::create([
          'servico_id' => $servico->id,
          'imagem' => $caminhoFoto
        ]);
      }
    }

    return response()->json(['message' => 'Atualização realizada com sucesso!', 'servico' => $servico], 200);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    try {
      $servico = Servico::findOrFail($id);
      foreach ($servico->fotos as $foto) {
        Storage::disk('public')->delete($foto->imagem);
        $foto->delete();
      }
      $servico->delete();

      return response()->json(['message' => 'Serviço deletado com sucesso!'], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Erro ao deletar o serviço'], 500);
    }
  }
}
