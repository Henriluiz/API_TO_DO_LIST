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

    public function tarefa()
    {
        try{
            $tarefas = Tarefa::all();;

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

    public function show($id)
    {
        $tarefa = Tarefa::find($id);

        if (!$tarefa) {
            return response()->json([
                'message' => 'Tarefa não encontrada'
            ], 404);
        }

        return response()->json($tarefa, 200);
    }


    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {

            $tarefa = Tarefa::find($id);

             if (!$tarefa) {
                return response()->json([
                    'error' => 'Tarefa não encontrada!',
                ], 500);
            }

            $dados = $request->validate([
                'nome' => 'sometimes|string|max:255',
                'DataInicio' => 'sometimes|date',
                'DataLimite' => 'sometimes|date',
                'tipo' => 'sometimes|in:Trabalho,Estudo,Lazer',
                'StatusTarefa' => 'sometimes|in:Pendente,Em Andamento,Concluída',
            ]);

           
            if (empty($dados)) {
                return response()->json([
                    'message' => 'Nenhum dado válido enviado'
                ], 400);
            }

            $tarefa->update($dados);

            DB::commit();
            return response()->json([
                'message' => 'Tarefa atualizado com sucesso',
                'tarefa' => $tarefa,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Erro ao atualizar tarefa',
                'details' => $e->getMessage(),
            ], 500);

        }
    }

    public function excluir($id, Request $request)
    {
        DB::beginTransaction();
        try {

            $tarefas = Tarefa::find($id);

            if (!$tarefas) {
                return response()->json([
                    'error' => 'Tarefa não encontrada!',
                ], 500);
            }

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
