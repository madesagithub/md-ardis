<?php

use App\Models\Maquina;
use App\Models\Material;
use App\Models\User;
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
			$table->string('nome');
			$table->integer('numero');
			$table->foreignIdFor(Material::class);
			$table->foreignIdFor(Maquina::class);
			$table->time('tempo_maquina', $precision = 0);
			$table->foreignIdFor(User::class);
			$table->float('aproveitamento');
			$table->time('tempo', $precision = 0);
			$table->datetime('data_processamento');
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
