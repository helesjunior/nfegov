<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNfeItensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nfe_itens', function (Blueprint $table) {
            $table->id();
            $table->integer('nfe_id');
            $table->integer('sequencial');
            $table->text('descricao');
            $table->integer('cfop');
            $table->string('unidade_medida');
            $table->float('quantidade',17,4);
            $table->decimal('valor_unitario',25,10);
            $table->decimal('valor_total',17,2);
            $table->string('unidade_medida_tributado');
            $table->float('quantidade_tributado',17,4);
            $table->decimal('valor_unitario_tributado',25,10);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('nfe_id')->references('id')->on('nfes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nfe_itens');
    }
}
