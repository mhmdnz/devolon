<?php

namespace Tests\Feature;

use App\Models\Offer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_calculate_success()
    {
        $offer = Offer::factory()->create()->first();
        $response = $this->postJson("api/checkout", [
            ['id' => $offer->product->id]
        ]);

        $response->assertStatus(200);
        $response->assertSee('price_with_discount');
    }

    public function test_calculate_validation_error()
    {
        $offer = Offer::factory()->create()->first();
        $response = $this->postJson("api/checkout", [
            ['id' => ($offer->product->id) + 1]
        ]);

        $response->assertStatus(422);
        $response->assertSee('The given data was invalid.');
    }
}
