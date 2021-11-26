<?php

namespace Database\Factories;

use App\Enumerations\Commission;
use App\Models\Sale;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        $value  = round($this->faker->randomFloat(), 2);
        $seller = Seller::factory()->create();

        return [
            'description' => $this->faker->realText,
            'value' => $value,
            'commission' => Commission::applyPercentage($value),
            'seller_id' => $seller,
        ];
    }
}
