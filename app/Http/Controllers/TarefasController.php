<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TarefasController extends Controller
{
    public function createTar(Request $request)
    {
        DB::beginTransaction();
        try{
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'DataInicio' => 'required|date',
                'DataLimite' => 'required|date',
                'tipo' => 'required|in:Trabalho,Estudo,Lazer',
                'StatusTarefa' => 'required|in:Pendente,Em Andamento,Concluída',
            ]);

            $tarefa = Tarefa::create([
                'nome' => $validatedData['nome'],
                'DataInicio' => $validatedData['DataInicio'],
                'DataLimite' => $validatedData['DataLimite'],
                'tipo' => $validatedData['tipo'],
                'StatusTarefa' => $validatedData['StatusTarefa'],
            ]);


            DB::commit();

            return response()->json([
                'message' => 'Tarefa cadastrado com sucesso',
                'tarefa' => $tarefa
            ], 200);

        }catch(\Exception $e){
            DB::rollback();

            return response()->json([
                'error' => 'Erro ao cadastrar tarefa',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function tarefa(Request $request)
    {
        try{
            $tarefas = $request->Tarefa();

            return response()->json([
                'tarefa' => $tarefas,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao obter tarefa',
                'details' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

            $tarefas = $request->Tarefa();

            $dados = $request->validate([
                'nome' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|max:255|unique:tarefas$tarefass,email,'.$tarefas->id_usuario.',id_usuario',
                'telefone' => 'sometimes|string|max:20',
                'senha' => 'sometimes|min:8',
                'biografia' => 'sometimes|string|max:255',

            ]);


            $tarefas->update($dados);

            DB::commit();
            return response()->json([
                'message' => 'Tarefa atualizado com sucesso',
                'tarefas$tarefas' => $tarefas,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Erro ao atualizar tarefa',
                'details' => $e->getMessage(),
            ], 500);

        }
    }

    public function excluir(Request $request)
    {
        DB::beginTransaction();
        try {

            $tarefas = $request->Tarefa();

            $tarefas->tokens()->delete();

            $tarefas->delete();

            DB::commit();

            return response()->json([
                'message' => 'Tarefa excluída com sucesso',
            ], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => 'Erro ao excluir tarefa',
                'details' => $e->getMessage(),
            ], 500);

        }
    }
}
