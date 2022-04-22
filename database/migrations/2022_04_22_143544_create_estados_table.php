<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->id();
            $table->char('sigla', 2)->unique();
            $table->string('nome');
            // Tipo (Código Itens): Norte, Nordeste, Centro-Oeste, Sudeste e Sul
            $table->integer('regiao_id')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->timestamps();

            $table->softDeletes();

            $table->foreign('regiao_id')->references('id')->on('codigo_itens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estados');
    }
}
