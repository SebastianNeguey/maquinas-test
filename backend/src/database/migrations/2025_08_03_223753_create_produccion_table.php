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
        Schema::create('produccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maquina_id')->constrained('maquinas')->onDelete('cascade');
            $table->decimal('tiempo_produccion', 6, 2);
            $table->decimal('tiempo_inactividad', 6, 2)->nullable();
            $table->dateTime('fecha_hora_inicio_inactividad')->nullable();
            $table->dateTime('fecha_hora_termino_inactividad')->nullable();
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
        Schema::dropIfExists('produccion');
    }
};
