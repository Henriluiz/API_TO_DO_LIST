<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tarefas', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('id_user');
           $table->String('nome');
           $table->date('DataInicio');
           $table->date('DataLimite');
           $table->enum('tipo', ['Trabalho', 'Estudo', 'Lazer']);
           $table->enum('StatusTarefa', ['Pendente','Em Andamento', 'Concluída']);
           $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarefas');
    }
};
