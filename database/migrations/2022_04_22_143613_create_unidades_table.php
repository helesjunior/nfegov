<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_unidade');
            $table->string('cnpj');
            $table->string('ie')->nullable();
            $table->string('nome_resumido');
            $table->string('nome');
            $table->foreignId('estado_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('municipio_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('certificado_path');
            $table->string('certificado_pass');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidades');
    }
}
