<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function cadastro(Request $request)
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
    
}
