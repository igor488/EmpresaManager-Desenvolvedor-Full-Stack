<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unidade;
use App\Models\Bandeira;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bandeiraA = Bandeira::where('nome','Bandeira A')->first();
        $bandeiraB = Bandeira::where('nome','Bandeira B')->first();

        Unidade::create([
            'nome_fantasia'=>'Loja Alpha 1',
            'razao_social'=>'Alpha Comercio Ltda',
            'cnpj'=>'12.345.678/0001-90',
            'bandeira_id'=>$bandeiraA->id
        ]);

        Unidade::create([
            'nome_fantasia'=>'Loja Beta 1',
            'razao_social'=>'Beta Comercio Ltda',
            'cnpj'=>'98.765.432/0001-10',
            'bandeira_id'=>$bandeiraB->id
        ]);
    }
}
