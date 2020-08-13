<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmbarcacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('embarcacao', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('nome');
            $table->string('num_reg')->nullable();
            $table->string('matricula')->nullable()->default('xx');
            $table->string('num_certificado')->nullable()->default('xx');
            $table->integer('tipo_pesca');
            $table->string('num_imo')->nullable();
            $table->string('bandeira')->nullable();
            $table->float('comprimento')->nullable()->default(0);
            $table->float('largura')->nullable()->default(0);
            $table->float('altura')->nullable()->default(0);
            $table->float('peso')->nullable()->default(0);
            $table->date('data_inicio')->nullable()->default(date('Y-m-d'));
            $table->string('motor')->nullable();
            $table->string('imagem')->nullable();
            $table->integer('estado')->nullable()->default(0);
            $table->integer('galeria')->nullable()->default(0);
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
        Schema::dropIfExists('embarcacaos');
    }
}
