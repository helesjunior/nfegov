<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNfesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nfes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nsu_id')
                ->constrained()
                ->onDelete('cascade');
            $table->integer('fornecedor_id');
            $table->integer('numero');
            $table->string('chave')->unique();
            $table->integer('serie');
            $table->dateTime('data_emissao');
            $table->dateTime('data_saida_entrada')->nullable();
            $table->decimal('valor',17,2);
            $table->string('natureza_operacao');
            $table->text('xml');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nfes');
    }
}
