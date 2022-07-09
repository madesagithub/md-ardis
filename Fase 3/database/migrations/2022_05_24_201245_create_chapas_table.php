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
        Schema::create('chapas', function (Blueprint $table) {
            $table->id();
			$table->string('codigo');
			$table->foreignId('familia_id')
				->constrained('familia_chapas');
			$table->string('descricao')->nullable();
			$table->integer('comprimento')->nullable();
			$table->integer('largura')->nullable();
			$table->integer('espessura')->nullable();
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
        Schema::dropIfExists('chapas');
    }
};
