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
        Schema::create('necessidade_reaproveitamento', function (Blueprint $table) {
            $table->id();
			$table->foreignIdFor(Peca::class)
				->constrained();
			$table->foreignIdFor(Lote::class)
				->constrained();
			$table->integer('comprimento_peca');
			$table->integer('largura_peca');
			$table->integer('espessura_peca');
			$table->integer('quantidade');
			$table->date('data_embalagem')
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
        Schema::dropIfExists('necessidade_reaproveitamento');
    }
};
