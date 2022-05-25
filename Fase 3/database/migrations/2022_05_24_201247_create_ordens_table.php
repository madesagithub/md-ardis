<?php

use App\Models\Chapa;
use App\Models\Maquina;
use App\Models\Material;
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
			$table->integer('identificador');
			$table->integer('ordem');
			$table->foreignIdFor(Material::class);
			$table->foreignIdFor(Chapa::class);
			$table->float('aproveitamento');
			$table->time('tempo', $precision = 0);
			$table->boolean('active')
				->default(true);
			$table->date('data');
			$table->foreignIdFor(Maquina::class);
            $table->timestamps();
        });
		# Arquivo de entrada
		# file[0] = id (Plano (ddmmaaaa.hh.mm.ss).plano)
		# file[1] = Tempo
		# file[2] = No.
		# file[3] = %
		# file[4] = Desc. Material

		# file[5] = Código Chapa
		# file[6] = Comp. Chapa
		# file[7] = Larg. Chapa
		# file[8] = Qtd. Chapa

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
        Schema::dropIfExists('ordens');
    }
};
