<?php

use App\Models\LogicaArdis;
use App\Models\Plano;
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
        Schema::create('retalhos', function (Blueprint $table) {
            $table->id();
			$table->foreignIdFor(Plano::class)
				->constrained();
			$table->integer('comprimento_peca');
			$table->integer('largura_peca');
			$table->integer('espessura_peca');
			$table->integer('quantidade_programada');
			$table->integer('quantidade_produzida');
			$table->float('metro_quadrado_bruto_peca');
			$table->float('metro_quadrado_liquido_peca');
			$table->float('metro_quadrado_liquido_total_peca');
			$table->float('metro_cubico_liquido_total_peca');
			$table->integer('pecas_superproducao');
			$table->float('metro_quadrado_superproducao');
			$table->float('percentual_peca_plano');
			$table->foreignIdFor(LogicaArdis::class)
				->nullable()
				->constrained();
			$table->integer('nivel');
			$table->integer('prioridade');
			$table->float('percentual_produzido');
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
        Schema::dropIfExists('retalhos');
    }
};
