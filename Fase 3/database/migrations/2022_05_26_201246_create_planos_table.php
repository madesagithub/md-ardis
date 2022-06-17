<?php

use App\Models\Material;
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
			$table->integer('numero');
			$table->foreignIdFor(Projeto::class)
				->constrained();
			$table->foreignIdFor(Material::class)
				->constrained('materiais');
			$table->float('aproveitamento');
			$table->integer('quantidade_material');
			$table->time('tempo_processo', $precision = 0);
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
