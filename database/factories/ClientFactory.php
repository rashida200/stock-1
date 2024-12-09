<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->name,
            'type' => $this->faker->randomElement(['personne', 'entreprise']),
            'cin' => $this->faker->optional()->regexify('[0-9]{8}'),  // Generate random CIN without prefix
            'lice' => $this->faker->optional()->regexify('[A-Z0-9]{10}'),  // Generate random LICE without prefix
            'telephone' => $this->faker->phoneNumber,
            'adresse' => $this->faker->address,
            'adresse_projet' => $this->faker->optional()->address,
            'nombre_hectare' => $this->faker->optional()->randomFloat(2, 0, 100),
        ];
    }
}
