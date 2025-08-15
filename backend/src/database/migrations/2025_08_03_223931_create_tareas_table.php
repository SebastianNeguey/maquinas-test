<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maquina_id')->constrained()->onDelete('cascade');
            $table->foreignId('id_produccion')->nullable()->constrained('produccion')->onDelete('set null');
            $table->dateTime('fecha_hora_inicio');
            $table->dateTime('fecha_hora_termino');
            $table->decimal('tiempo_empleado', 5, 2)->default(0);
            $table->decimal('tiempo_produccion', 5, 2)->default(0);
            $table->enum('estado', ['PENDIENTE', 'COMPLETADA'])->default('PENDIENTE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tareas');
    }
};
