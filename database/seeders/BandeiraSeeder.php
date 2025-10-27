<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bandeira;
use App\Models\GrupoEconomico;

class BandeiraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alpha = GrupoEconomico::where('nome', 'Grupo Alpha')->first();
        $beta  = GrupoEconomico::where('nome', 'Grupo Beta')->first();

        Bandeira::create(['nome'=>'Bandeira A', 'grupo_economico_id'=>$alpha->id]);
        Bandeira::create(['nome'=>'Bandeira B', 'grupo_economico_id'=>$beta->id]);
    }
}
