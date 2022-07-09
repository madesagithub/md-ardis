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
        Schema::create('projeto_chapa', function (Blueprint $table) {
            $table->id();
			$table->foreignIdFor(Projeto::class)
				->constrained('projetos');
			$table->foreignIdFor(Chapa::class)
				->constrained('chapas');
			$table->integer('ordem');
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
        Schema::dropIfExists('projeto_chapa');
    }
};
