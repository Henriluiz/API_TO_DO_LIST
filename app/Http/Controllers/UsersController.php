<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function createUser(Request $request)
    {
        DB::beginTransaction();
        try {

            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:user,email',
                'senha' => 'required|string|min:6',
            ]);

            $user = User::create([
                'nome' => $validatedData['nome'],
                'email'=> $validatedData['email'],
                'senha'=>Hash::make($validatedData['senha']),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Usuário cadastrado com sucesso',
                'user' => $user,
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => 'Erro ao cadastrar Usuário',
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function login(Request $request)
    {

        try {

            $credenciais = $request->validate([
                'login' => 'required|string',
                'senha' => 'required',
            ]);

            $user = User::where('email', $credenciais['login'])->first();

            if (!$user) {
                return response()->json([
                    'message' => 'Usuário não encontrado'
                ], 404);
            }

            if (!Hash::check($credenciais['senha'], $user->senha)) {
                return response()->json([
                    'message' => 'Senha incorreta'
                ], 401);
            }

            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'message' => 'Login realizado com sucesso',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao processar login',
                'details' => $e->getMessage(),
            ], 404);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Logout realizado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao processar logout',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function user(Request $request)
    {
        try{
            $user = $request->User();

            return response()->json([
                'user' => $user,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao obter User',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateUser(Request $request)
    {
        DB::beginTransaction();
        try {

            $user = $request->User();

            $dados = $request->validate([
                'nome' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|max:255',
                'senha' => 'sometimes|min:8',
            ]);

            if (!$dados){
                return response()->json([
                'message' => 'Erro de campo inválido',
                ]);
            }

            if (isset($dados['senha'])) {
                $dados['senha_hash'] = Hash::make($dados['senha']);
                unset($dados['senha']);
            }
            
            $user->update($dados);

            DB::commit();
            return response()->json([
                'message' => 'Usuário atualizado com sucesso',
                'user' => $user,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Erro ao atualizar Usuário',
                'details' => $e->getMessage(),
            ], 500);

        }
    }

    public function deleteUser(Request $request)
    {
        DB::beginTransaction();
        try {

            $user = $request->User();

            $user->tokens()->delete();

            $user->delete();

            DB::commit();

            return response()->json([
                'message' => 'Usuário excluída com sucesso',
            ], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => 'Erro ao excluir usuário',
                'details' => $e->getMessage(),
            ], 500);

        }
    }
}
