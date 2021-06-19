<?php

namespace Database\Factories;

use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => \App\Models\Product::factory()->create()->id,
            'name' => Str::random(10),
            'quantity' => rand(2,50),
            'price' => rand(150,250),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
