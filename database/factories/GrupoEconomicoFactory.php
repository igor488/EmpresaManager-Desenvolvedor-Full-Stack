<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\GrupoEconomico;

class GrupoEconomicoFactory extends Factory
{
    protected $model = GrupoEconomico::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->company,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
