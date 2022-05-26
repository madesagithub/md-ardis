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
        Schema::create('pecas', function (Blueprint $table) {
            $table->id();
			$table->string('codigo');
			$table->string('descricao');
			$table->integer('comprimento');
			$table->integer('largura');
            $table->timestamps();
        });
		# Arquivo de entrada
		# file[0] = id (Plano (ddmmaaaa.hh.mm.ss).plano)
		# file[1] = Tempo
		# file[2] = No.
		# file[3] = %
		# file[4] = Desc. Material
		# file[5] = Código Peca
		# file[6] = Comp. Peca
		# file[7] = Larg. Peca
		# file[8] = Qtd. Peca
		# file[9] = Código Material
		# file[10] = Descrição
		# file[11] = Comprimento
		# file[12] = Largura
		# file[13] = Quant
		# file[14] = Ordem
		# file[15] = Data ordem
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pecas');
    }
};
