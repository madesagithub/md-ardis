<?php

use App\Models\Peca;
use App\Models\Plano;
use App\Models\Projeto;
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
        Schema::create('ordens', function (Blueprint $table) {
			$table->id();
			$table->integer('ordem');
			$table->foreignIdFor(Peca::class)
				->constrained('pecas');
			$table->integer('quantidade_peca');
			$table->date('data_embalagem');
			$table->float('produzido');
			$table->foreignIdFor(Plano::class)
				->constrained();
			$table->boolean('active')->default(true);
			$table->timestamps();
        });

		# Arquivo de entrada
		# line[0]	= #				= numero
		# line[1] 	= Código		= codigo_peca
		# line[2] 	= Descrição		= descricao_peca
		# line[3]	= Comp.			= comprimento_peca
		# line[4]	= Larg.			= largura_peca
		# line[5] 	= Qtd.			= quantidade_peca
		# line[6]	= Ordem			= ordem
		# line[6]	= Data			= data_embalagem
		# line[7]	= Produzido		= produzido
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordens');
    }
};
