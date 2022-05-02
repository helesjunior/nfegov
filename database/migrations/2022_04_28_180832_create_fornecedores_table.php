<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFornecedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj')->unique();
            $table->string('ie')->nullable();
            $table->string('im')->nullable();
            $table->string('nome');
            $table->string('endereco');
            $table->string('endereco_numero')->nullable();
            $table->string('bairro')->nullable();
            $table->foreignId('estado_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('municipio_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('cep')->nullable();
            $table->string('telefone')->nullable();
            $table->string('cnae')->nullable();

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
        Schema::dropIfExists('fornecedores');
    }
}
