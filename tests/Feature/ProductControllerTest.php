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
        $response = $this->postJson('/api/product', [
            'name' => 'firstTest',
            'unit_price' => 10,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', ['name' => 'firstTest']);
    }

    public function test_create_validation_error()
    {
        $response = $this->postJson('/api/product', [
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
        $response = $this->deleteJson("/api/product/$product->id");
        $this->assertDatabaseMissing('products', ['name' => $product->name]);
        $response->assertStatus(200);
    }

    public function test_delete_wrong_product_id()
    {
        $response = $this->deleteJson("/api/product/111");//wrong id
        $response->assertSee('No query results for model');
        $response->assertStatus(404);
    }

    public function test_update_success()
    {
        $product = (Product::factory(1)->create())->first();
        $this->assertDatabaseHas('products', ['name' => $product->name]);
        $this->putJson("/api/product/$product->id", [
           'name' => $product->name . 'changed_name'
        ]);
        $this->assertDatabaseHas('products', ['name' => $product->name . 'changed_name']);
    }

    public function test_upsert_success()
    {
        $this->postJson("/api/products", [
            ['name' => 'test1', 'unit_price' => 10],
            ['name' => 'test2', 'unit_price' => 10],
            ['name' => 'test3', 'unit_price' => 10]
        ]);
        $this->assertDatabaseCount('products', 3);
        $this->assertDatabaseHas('products', ['name' => 'test1']);
    }
}
