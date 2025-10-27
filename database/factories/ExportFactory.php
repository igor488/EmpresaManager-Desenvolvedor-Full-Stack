<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExportFactory extends Factory
{
    protected $model = \App\Models\Export::class;

    public function definition(): array
    {
        // Valores possíveis para status (baseado na constraint)
        $statusOptions = ['completed', 'processing', 'failed'];

        return [
            'user_id' => User::factory(),
            'file_name' => 'export_' . now()->timestamp . '.xlsx',
            'status' => $this->faker->randomElement($statusOptions),
            'filters' => json_encode([]),
        ];
    }
}
