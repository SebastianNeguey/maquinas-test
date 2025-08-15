<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->decimal('tiempo_inactividad', 6, 2)->default(0);
            $table->dateTime('fecha_hora_inicio_inactividad')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('fecha_hora_termino_inactividad')->default(DB::raw('CURRENT_TIMESTAMP'));
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
