<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternautaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internauta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->integer('tipo')->nullable()->default(1);
            $table->string('servidor')->nullable()->default('localhost');
            $table->string('servidor_id')->nullable();
            $table->string('telefone')->nullable()->unique();;
            $table->string('facebook')->nullable();
            $table->string('nif')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('blog')->nullable();
            $table->string('rua')->nullable();
            $table->string('pais')->nullable();
            $table->string('cidade')->nullable();
            $table->string('caixa_postal')->nullable();
            $table->string('imagem')->nullable();
            $table->integer('sessao')->nullable()->default(0);
            $table->integer('estado')->nullable()->default(1);
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
        Schema::dropIfExists('internauta');
    }
}
