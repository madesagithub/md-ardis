<?php

use App\Models\Chapa;
use App\Models\Ordem;
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
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
			$table->foreignIdFor(Ordem::class)
				->constrained('ordens');
			$table->string('base');
			$table->foreignIdFor(Chapa::class)
				->constrained('chapas');
			$table->string('dep_origem');
			$table->string('loc_origem');
			$table->string('dep_destino');
			$table->string('loc_destino');
			$table->float('quantidade');
			$table->integer('cod_emitente');
			$table->boolean('success');
			$table->text('message')
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
        Schema::dropIfExists('movements');
    }
};
