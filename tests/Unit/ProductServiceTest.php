<?php

namespace Tests\Unit;

use App\Http\DTO\DeleteResultDTO;
use App\Http\DTO\UpdateResultDTO;
use App\Models\Offer;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_get_model_repository(): void
    {
        $productRepository = \Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $productService = new ProductService($productRepository);
        $result = $productService->getModelRepository();
        $this->assertEquals($result, $productRepository);
    }

    public function test_get_offers_with_offer(): void
    {
        $productRepository = \Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $productService = new ProductService($productRepository);
        $offer = Offer::factory()->make();
        $result = $productService->getOffers($offer->product, $offer);
        $this->assertEquals($result, collect()->add($offer));
    }

    public function test_get_offers_without_offer(): void
    {
        $productRepository = \Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $offer = Offer::factory()->make();
        $expectResult = collect()->add($offer);
        $productRepository->shouldReceive('getOffers')
            ->once()
            ->withArgs([$offer->product])
            ->andReturn($expectResult);
        $productService = new ProductService($productRepository);
        $result = $productService->getOffers($offer->product);
        $this->assertEquals($result, $expectResult);
    }

    public function test_is_product_related_to_offer_true(): void
    {
        $productRepository = \Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $productService = new ProductService($productRepository);
        $offer = Offer::factory()->make();
        $result = $productService->isProductRelatedToOffer($offer->product, $offer);
        $this->assertTrue($result);
    }

    public function test_is_product_related_to_offer_false(): void
    {
        $productRepository = \Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $productService = new ProductService($productRepository);
        $offer = Offer::factory()->make();
        $product = Product::factory()->make();
        $result = $productService->isProductRelatedToOffer($product, $offer);
        $this->assertFalse($result);
    }

    public function test_get_products_with_product(): void
    {
        $productRepository = \Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $productService = new ProductService($productRepository);
        $product = Product::factory()->make();
        $expectedResult = collect()->add($product);
        $result = $productService->getProducts($product);
        $this->assertEquals($expectedResult, $result);
    }

    public function test_get_products_without_product(): void
    {
        $productRepository = \Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $product = Product::factory()->make();
        $expectedResult = collect()->add($product);
        $productRepository->shouldReceive('all')->once()
            ->andReturn($expectedResult);
        $productService = new ProductService($productRepository);

        $result = $productService->getProducts();
        $this->assertEquals($expectedResult, $result);
    }

    public function test_save(): void
    {
        $product = Product::factory()->make();
        $fakeArgs = ['test'];
        $productRepository = \Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $productRepository->shouldReceive('save')
            ->once()
            ->withArgs([$fakeArgs])
            ->andReturn($product);
        $productService = new ProductService($productRepository);
        $result = $productService->save($fakeArgs);
        $this->assertEquals($product, $result);
    }

    public function test_update(): void
    {
        $product = Product::factory()->make();
        $expectedResult = new UpdateResultDTO(true);
        $fakeArgs = ['test'];
        $productRepository = \Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $productRepository->shouldReceive('update')
            ->once()
            ->withArgs([$product, $fakeArgs])
            ->andReturnTrue();
        $productService = new ProductService($productRepository);
        $result = $productService->update($product, $fakeArgs);
        $this->assertEquals($expectedResult, $result);
    }

    public function test_delete(): void
    {
        $product = Product::factory()->make();
        $expectedResult = new DeleteResultDTO(true);
        $productRepository = \Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $productRepository->shouldReceive('delete')
            ->once()
            ->withArgs([$product])
            ->andReturnTrue();
        $productService = new ProductService($productRepository);
        $result = $productService->delete($product);
        $this->assertEquals($expectedResult, $result);
    }

    public function test_find_or_fail(): void
    {
        $product = Product::factory()->make();
        $productRepository = \Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $productRepository->shouldReceive('findOrFail')
            ->once()
            ->withArgs([$product->id])
            ->andReturn($product);
        $productService = new ProductService($productRepository);
        $result = $productService->findOrFail($product->id);
        $this->assertEquals($product, $result);
    }
}
