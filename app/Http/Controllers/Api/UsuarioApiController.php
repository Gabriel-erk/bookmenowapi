<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioApiController extends Controller
{
    public function index()
    {
        try {
            $usuarios = User::all();
            return response()->json([$usuarios], 200);
        } catch (\Throwable $th) {
            return response()->json(["Erro" => "Erro ao listar dados"], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $usuario = User::findOrFail($id);
            return response()->json([$usuario], 200);
        } catch (\Exception $e) {
            return response()->json(["Erro" => "Não foi possivel encontrar o usuário"]);
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'nome' => 'required',
            'email' => 'required|string|email|unique:usuarios',
            'password' => 'required|min:8|confirmed'
        ]);

        try {
            $usuario = User::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json($usuario, 200);
        } catch (Exception $e) {
            return response()->json(["Erro" => "Não foi possivel salvar o usuário"]);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|string|email|unique:usuarios,email,' . $id,
            'password' => 'nullable|min:8|confirmed'
        ]);
        try {
            $usuario = User::findOrFail($id);

            $usuario->update([
                'nome' => $request->nome,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $usuario->password
            ]);

            return response()->json($usuario, 200);
        } catch (Exception $e) {
            // return response()->json(["Erro" => "Erro ao atualizar usuário"], 500);
            return response()->json(["Erro" => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $usuario = User::findOrFail($id);
            $usuario->delete();
            return response()->json(["message" => "Usuário deletado com sucesso"], 200);
        } catch (Exception $e) {
            // return response()->json(["Erro" => "Erro ao deletar usuário"], 500);
            return response()->json(["Erro" => $e->getMessage()], 500);
        }
    }
}
