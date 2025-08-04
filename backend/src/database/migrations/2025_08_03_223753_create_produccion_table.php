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
            $table->decimal('tiempo_produccion', 5, 2);
            $table->decimal('tiempo_inactividad', 5, 2);
            $table->dateTime('fecha_hora_inicio_inactividad');
            $table->dateTime('fecha_hora_termino_inactividad');
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
