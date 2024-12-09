<?php

namespace Database\Factories;

use App\Models\Produit;
use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProduitFactory extends Factory
{
    protected $model = Produit::class;

    private static $referenceCounter = 0;

    public function definition()
    {
        self::$referenceCounter++;

        $reference = '1-' . str_pad(self::$referenceCounter, 4, '0', STR_PAD_LEFT);

        return [
            'reference' => $reference,  
            'designation' => $this->faker->word,
            'quantity' => $this->faker->numberBetween(1, 100),
            'prix_achat_ht' => $this->faker->randomFloat(2, 5, 100),
            'tva' => $this->faker->randomFloat(2, 5, 20),
            'prix_vente' => $this->faker->randomFloat(2, 10, 200),
            'fournisseur_id' => Fournisseur::inRandomOrder()->first()->id,
        ];
    }
}
