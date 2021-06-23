<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OfferControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_success()
    {
        $product = Product::factory()->create()->first();
        $response = $this->postJson("/api/products/$product->id/offers", [
            'name' => 'firstTest',
            'quantity' => 10,
            'price' => 40
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('offers', ['name' => 'firstTest']);
    }

    public function test_create_validation_error()
    {
        $product = Product::factory()->create()->first();
        $response = $this->postJson("/api/products/$product->id/offers", [
            'name' => 'firstTest',
            'quantity' => 10,
//            'price' => 40(missing parameters)
        ]);
        $response->assertStatus(422);
        $response->assertSee('The given data was invalid.');
        $this->assertDatabaseMissing('offers', ['name' => 'firstTest']);
    }

    public function test_show()
    {
        $product = Product::factory()->create()->first();
        $offer = Offer::factory([
            'product_id' => $product->id
        ])->create()->first();
        $response = $this->get("/api/products/1/offers");
        $response->assertSee($offer->name);
        $response->assertStatus(200);
    }

    public function test_delete()
    {
        $product = Product::factory()->create()->first();
        $offer = Offer::factory([
            'product_id' => $product->id
        ])->create()->first();
        $this->assertDatabaseHas('offers', ['id' => $offer->id]);
        $response = $this->deleteJson("/api/products/$product->id/offers/$offer->id");
        $this->assertDatabaseMissing('offers', ['id' => $offer->id]);
        $response->assertStatus(200);
    }
}
