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
        $response = $this->postJson("/api/products/1/offers", [
            'name' => 'firstTest',
            'quantity' => 10,
            'price' => 40
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('offers', ['name' => 'firstTest']);
    }

    public function test_create_validation_error()
    {
        $response = $this->postJson("/api/products/1/offers", [
            'name' => 'firstTest',
            'quantity' => 10,
//            'price' => 40(missing parameters)
        ]);
        $response->assertStatus(422);
        $response->assertSee('The given data was invalid.');
        $this->assertDatabaseMissing('offers', ['name' => 'firstTest']);
    }

    public function test_show_undefined_product()
    {
        $response = $this->get("/api/products/3/offers/1");

        $response->assertStatus(404);
    }

    public function test_show_undefined_offer()
    {
        $response = $this->get("/api/products/1/offers/6");

        $response->assertStatus(404);
    }

    public function test_show()
    {
        $response = $this->get("/api/products/1/offers/1");
        $responseData = json_decode($response->getContent())->data;
        $this->assertCount(1, $responseData);
        $response->assertStatus(200);
    }

    public function test_show_collection_offer()
    {
        $response = $this->getJson('/api/products/1/offers');
        $responseData = json_decode($response->getContent())->data;

        $response->assertStatus(200);
        $this->assertCount(3, $responseData);
        $this->assertEquals($responseData[1]->name, 'offer2');
    }

    public function test_show_wrong_product_relation()
    {
        $response = $this->getJson('/api/products/2/offers/1');//the given offer is not related to product
        $responseData = json_decode($response->getContent())->data;

        $this->assertEquals($responseData->error_message, 'This offer is not related to the given product');
    }

    public function test_delete()
    {
        $this->assertDatabaseHas('offers', ['id' => 1]);
        $response = $this->deleteJson("/api/products/1/offers/1");
        $this->assertDatabaseMissing('offers', ['id' => 1]);
        $response->assertStatus(200);
    }

    public function test_delete_wrong_product_relation()
    {
        $response = $this->deleteJson("/api/products/2/offers/1");
        $responseData = json_decode($response->getContent())->data;

        $this->assertEquals($responseData->error_message, 'This offer is not related to the given product');
    }

    public function test_update()
    {
        $offer1 = Offer::find(1);
        $this->assertEquals($offer1->name, 'offer1');
        $this->putJson("/api/products/1/offers/1", [
            'name' => 'offer1_edited'
        ]);
        $updatedOffer = Offer::find(1);
        $this->assertEquals($updatedOffer->name, 'offer1_edited');
    }

    public function test_update_wrong_product_relation()
    {
        $response = $this->putJson("/api/products/2/offers/1", [
            'name' => 'offer1_edited'
        ]);
        $responseData = json_decode($response->getContent())->data;

        $this->assertEquals($responseData->error_message, 'This offer is not related to the given product');
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
}
