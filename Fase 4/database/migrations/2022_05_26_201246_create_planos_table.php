<?php

use App\Models\Chapa;
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
        Schema::create('planos', function (Blueprint $table) {
            $table->id();
			$table->integer('numero_layout');
			$table->foreignIdFor(Projeto::class)
				->constrained();
			$table->foreignIdFor(Chapa::class)
				->constrained('chapas');
			$table->integer('quantidade_chapa');
			$table->float('metro_quadrado_chapa');
			$table->float('aproveitamento');
			$table->integer('carregamentos');
			$table->time('tempo_corte', $precision = 0);
			$table->float('metro_cubico');
			$table->integer('quantidade_por_corte');
			$table->float('percentual_ocupacao_maquina');
			$table->float('custo_por_metro');
			$table->integer('cortes_n1');
			$table->integer('cortes_n2');
			$table->integer('cortes_n3');
			$table->boolean('active')->default(true);
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
        Schema::dropIfExists('planos');
    }
};
