<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_success()
    {
        $response = $this->postJson('/api/products', [
            'name' => 'firstTest',
            'unit_price' => 10,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', ['name' => 'firstTest']);
    }

    public function test_create_validation_error()
    {
        $response = $this->postJson('/api/products', [
            'name' => 'firstTest',
//            'unit_price' => 10, (missing parameters)
        ]);
        $response->assertStatus(422);
        $response->assertSee('The given data was invalid.');
        $this->assertDatabaseMissing('products', ['name' => 'firstTest']);
    }

    public function test_delete_success()
    {
        $product = (Product::factory(1)->create())->first();
        $this->assertDatabaseHas('products', ['name' => $product->name]);
        $response = $this->deleteJson("/api/products/$product->id");
        $this->assertDatabaseMissing('products', ['name' => $product->name]);
        $response->assertStatus(200);
    }

    public function test_delete_wrong_product_id()
    {
        $response = $this->deleteJson("/api/products/111");//wrong id
        $response->assertSee('No query results for model');
        $response->assertStatus(404);
    }

    public function test_update_success()
    {
        $product = (Product::factory(1)->create())->first();
        $this->assertDatabaseHas('products', ['name' => $product->name]);
        $res = $this->putJson("/api/products/$product->id", [
           'name' => $product->name . 'changed_name'
        ]);

        $this->assertDatabaseHas('products', ['name' => $product->name . 'changed_name']);
    }
}
