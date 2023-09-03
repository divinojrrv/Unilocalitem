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
        Schema::create('imagens_objetos', function (Blueprint $table) {
            $table->id('ID');
            
            $table->bigInteger('IDIMAGEM')->unsigned();
            $table->unsignedBigInteger('IDOBJETO_PUBLICACOES')->nullable();
            $table->unsignedBigInteger('IDOBJETO_RESGATE')->nullable();
            $table->integer('TIPO');

            $table->foreign('IDIMAGEM')->references('ID')->on('imagens')->onDelete('cascade')->onUpdate('cascade');


            // Chave estrangeira para a tabela resgates
            $table->foreign('IDOBJETO_RESGATE', 'fk_idobjeto_resgates')->references('ID')->on('resgates')->onDelete('cascade')->onUpdate('cascade');
            // Chave estrangeira para a tabela publicacoes
            $table->foreign('IDOBJETO_PUBLICACOES', 'fk_idobjeto_publicacoes')->references('ID')->on('publicacoes')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagens_objetos');
    }
};
