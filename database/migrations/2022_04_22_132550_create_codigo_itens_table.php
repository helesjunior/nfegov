<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodigoItensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigo_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('codigo_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('descres', 10);
            $table->string('descricao', 100);
            $table->softDeletes();
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
        Schema::dropIfExists('codigo_itens');
    }
}
