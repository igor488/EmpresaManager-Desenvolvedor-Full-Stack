<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Bandeira;
use App\Models\GrupoEconomico;

class BandeiraFactory extends Factory
{
    protected $model = Bandeira::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->word,
            'grupo_economico_id' => GrupoEconomico::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
