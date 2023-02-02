<?php

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
        Schema::create('reaproveitamentos', function (Blueprint $table) {
            $table->id();
			$table->string('nome_projeto');
			$table->string('numero_plano');
			$table->integer('comprimento_peca');
			$table->integer('largura_peca');
			$table->integer('espessura_peca');
			$table->foreignId('familia_id')
				->constrained('familia_chapas');
			$table->integer('quantidade_pecas');
			$table->foreignIdFor(Projeto::class)
				->constrained()
				->nullable();
			$table->foreignIdFor(Plano::class)
				->constrained()
				->nullable();
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
        Schema::dropIfExists('reaproveitamentos');
    }
};
