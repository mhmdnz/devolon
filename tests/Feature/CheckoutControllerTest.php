<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_calculate_first_scenario_success(): void
    {
        $response = $this->postJson("api/checkout", [
            ['id' => 1]
        ]);
        $offersData = json_decode($response->getContent())->data;

        $response->assertStatus(200);
        $this->assertEquals(100, $offersData->price_with_discount);
        $response->assertSee('price_with_discount');
    }

    public function test_calculate_second_scenario_success(): void
    {
        $checkoutData = $this->getCheckoutData([
            ['id' => 1],
            ['id' => 1],
            ['id' => 1]
        ]);
        $this->assertEquals(250, $checkoutData->price_with_discount);
        $this->assertEquals(50, $checkoutData->discount);
        $this->assertEquals(300, $checkoutData->price_without_discount);
    }

    public function test_calculate_third_scenario_success(): void
    {
        $checkoutData = $this->getCheckoutData([
            ['id' => 1],
            ['id' => 1],
            ['id' => 1],
            ['id' => 1],
            ['id' => 1],
            ['id' => 1],
            ['id' => 1],
            ['id' => 1]
        ]);
        $this->assertEquals(600, $checkoutData->price_with_discount);
        $this->assertEquals(200, $checkoutData->discount);
        $this->assertEquals(800, $checkoutData->price_without_discount);
    }

    public function test_calculate_validation_error(): void
    {
        $response = $this->postJson("api/checkout", [
            ['id' => 3]
        ]);

        $response->assertStatus(422);
        $response->assertSee('The given data was invalid.');
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    private function getCheckoutData(array $ids): \stdClass
    {
        $response = $this->postJson("api/checkout", $ids);
        $checkoutData = json_decode($response->getContent())->data;

        return $checkoutData;
    }
}
