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
