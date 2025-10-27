<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Colaborador;
use App\Models\Unidade;

class ColaboradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $u1 = Unidade::where('nome_fantasia','Loja Alpha 1')->first();
        $u2 = Unidade::where('nome_fantasia','Loja Beta 1')->first();

        Colaborador::create([
            'nome'=>'João Silva',
            'email'=>'joao@alpha.com',
            'cpf'=>'123.456.789-00',
            'unidade_id'=>$u1->id
        ]);

        Colaborador::create([
            'nome'=>'Maria Souza',
            'email'=>'maria@beta.com',
            'cpf'=>'987.654.321-00',
            'unidade_id'=>$u2->id
        ]);
    }
}
