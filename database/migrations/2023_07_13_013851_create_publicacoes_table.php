<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('publicacoes', function (Blueprint $table) {
            $table->id('ID');
            $table->string('NOME', 255);
            $table->string('DESCRICAO', 255);
            $table->dateTime('DATAHORA');
            $table->integer('STATUS')->default(1);
            $table->bigInteger('IDCATEGORIA')->unsigned();
            $table->bigInteger('IDBLOCO')->unsigned();
            $table->bigInteger('IDUSUARIO')->unsigned();

            $table->foreign('IDCATEGORIA')->references('ID')->on('categorias')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('IDBLOCO')->references('ID')->on('blocos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('IDUSUARIO')->references('ID')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicacoes');
    }
};
