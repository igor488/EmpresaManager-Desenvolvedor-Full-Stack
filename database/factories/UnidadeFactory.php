<?php

namespace Database\Factories;

use App\Models\Bandeira;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnidadeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome_fantasia' => $this->faker->company(),
            'razao_social' => $this->faker->company() . ' LTDA',
            'cnpj' => $this->generateUniqueCnpj(),
            'bandeira_id' => Bandeira::factory(),
        ];
    }

    private function generateUniqueCnpj(): string
    {
        // Usar timestamp + random para garantir unicidade
        $timestamp = time();
        $random = rand(1000, 9999);

        $base = substr(str_pad($timestamp . $random, 8, '0', STR_PAD_LEFT), -8);
        $n1 = substr($base, 0, 2);
        $n2 = substr($base, 2, 3);
        $n3 = substr($base, 5, 3);

        return sprintf('%s.%s.%s/0001-10', $n1, $n2, $n3);
    }
}
