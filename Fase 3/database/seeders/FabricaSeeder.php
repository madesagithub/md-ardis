<?php

namespace Database\Seeders;

use App\Models\Fabrica;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FabricaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fabrica = Fabrica::create([
			'nome' => 'Fábrica Vermelha'
		]);

		$fabrica = Fabrica::create([
			'nome' => 'Fábrica Branca'
		]);
    }
}
