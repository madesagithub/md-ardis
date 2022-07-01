<?php

use App\Models\Maquina;
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
        Schema::create('projetos', function (Blueprint $table) {
			$table->id();
			$table->string('nome');
			$table->foreignIdFor(Maquina::class)
				->constrained('maquinas');
			$table->foreignIdFor(User::class)
				->constrained('users');
			$table->date('data_processamento');
			$table->time('tempo_maquina');
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
        Schema::dropIfExists('projetos');
    }
};
