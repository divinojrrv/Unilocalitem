<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Criar o trigger para deletar registros da tabela "imagens" quando um registro da tabela "imagens_objetos" for deletado
        \DB::unprepared('
            CREATE TRIGGER tr_delete_imagens
            BEFORE DELETE ON imagens_objetos FOR EACH ROW
            BEGIN
                DELETE FROM imagens WHERE ID = OLD.IDIMAGEM;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remover o trigger criado
        \DB::unprepared('DROP TRIGGER IF EXISTS tr_delete_imagens');
    }
};