<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNsusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nsus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unidade_id')
                ->constrained()
                ->onDelete('cascade');
            $table->integer('ultimo_nsu');
            $table->text('xml')->nullable();

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
        Schema::dropIfExists('nsus');
    }
}
