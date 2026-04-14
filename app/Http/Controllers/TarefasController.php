<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TarefasController extends Controller
{
    public function createTar(Request $request)
    {   

        $id_user = $request->id_user;

        DB::beginTransaction();
        try{
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'DataInicio' => 'required|date',
                'DataLimite' => 'required|date',
                'tipo' => 'required|in:Trabalho,Estudo,Lazer'
            ]);

            $tarefa = Tarefa::create([
                'id_user' => $id_user,
                'nome' => $validatedData['nome'],
                'DataInicio' => $validatedData['DataInicio'],
                'DataLimite' => $validatedData['DataLimite'],
                'tipo' => $validatedData['tipo'],
                'StatusTarefa' => 'Pendente',
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
            $id_user = $request->id_user;

            $tarefas = Tarefa::where('id_user', $id_user)->get();

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

            if (Tarefa::find($id)->StatusTarefa === 'Pendente') {
                $dados = ["StatusTarefa" => "Em Andamento"];
            } else if (Tarefa::find($id)->StatusTarefa === 'Em Andamento') {
                $dados = ["StatusTarefa" => "Concluída"];
            } else {
                $dados = ["StatusTarefa" => "Pendente"];
            }


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
