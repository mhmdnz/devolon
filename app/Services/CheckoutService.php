<?php

namespace App\Services;

use App\Http\DTO\CheckoutDTOInterface;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Interfaces\CheckoutServiceInterface;
use Illuminate\Support\Collection;

class CheckoutService implements CheckoutServiceInterface
{

    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private CheckoutDTOInterface $checkoutDTO
    )
    {
    }

    public function calculateCheckout(array $productIds): CheckoutDTOInterface
    {
        $productIdCollection = collect($productIds);
        $uniqueProducts = $productIdCollection->groupBy('id');
        $bestPrice= 0;
        $priceWithoutDiscount = 0;
        $uniqueProducts->each(function ($content, $productId) use (&$bestPrice, &$priceWithoutDiscount){
            $product = $this->productRepository->find($productId);
            $priceWithoutDiscount += ($product->unit_price * count($content));
            $bestPrice += $this->getBestPrice($product, count($content));
        });
        $this->checkoutDTO->setPrice($bestPrice);
        $this->checkoutDTO->setDiscount($priceWithoutDiscount - $bestPrice);

        return $this->checkoutDTO;
    }

    public function getBestPrice(Product $product, $repeatCount): int
    {
        if ($repeatCount == 1) {
            return $product->unit_price;
        }
        $offers = $this->productRepository->getOffersByQuantityLimit($product, $repeatCount);
        $offerDiscountCollection = $this->getOffersDiscountCollection($offers, $product);

        return $this->findBestOffer($product, $offerDiscountCollection, $repeatCount);
    }

    /**
     * @param Collection $offers
     * @param Product $product
     * @return Collection
     */
    private function getOffersDiscountCollection(Collection $offers, Product $product): Collection
    {
        $offersDiscountCollection = collect();
        $offers->each(function ($offer) use ($offersDiscountCollection, $product) {
            $offersDiscountCollection->add([
                'id' => $offer->id,
                'name' => $offer->name,
                'price' => $offer->price,
                'quantity' => $offer->quantity,
                'discountPercent' => 100 - (($offer->price * 100) / ($product->unit_price * $offer->quantity))
            ]);
        });

        return $offersDiscountCollection;
    }

    private function findBestOffer(Product $product, $offerDiscountCollection, $repeatCount): float
    {
        $currentBestOffer = $offerDiscountCollection->where('quantity', '<=', $repeatCount)->sortByDesc('discountPercent')->first();
        if (!$currentBestOffer) {
            return $repeatCount * $product->unit_price;
        }
        $finalState = $this->getBestPriceByRepeatCount($product, $offerDiscountCollection, $repeatCount);
        $result = $this->calculateStateDiscount($finalState);

        $offerDiscountCollection = $offerDiscountCollection->reject(function ($item, $value) use ($currentBestOffer) {
            return $item['id'] == $currentBestOffer['id'];
        });
        while ($result < $offerDiscountCollection->max('discountPercent')) {
            $finalState = $this->getBestPriceByRepeatCount($product, $offerDiscountCollection, $repeatCount);
            $newResult = $this->calculateStateDiscount($finalState);
            if ($newResult > $result) {
                $result = $newResult;
            }
        }

        return $finalState->sum('price');
    }

    private function getBestPriceByRepeatCount(
        Product $product,
        $offerDiscountCollection,
        $repeatCount,
        $currentState = null
    ): Collection
    {
        $currentBestOffer = $offerDiscountCollection->where('quantity', '<=', $repeatCount)->sortByDesc('discountPercent')->first();
        $minOfferQuantity = $offerDiscountCollection->min('quantity');
        $numberOfBestCurrentOfferUsage = floor($repeatCount / $currentBestOffer['quantity']);
        $numberOfBestQuantity = $numberOfBestCurrentOfferUsage * $currentBestOffer['quantity'];
        $retain = $repeatCount - $numberOfBestQuantity;
        if (!$currentState) {
            $currentState = collect();
        }
        $currentState->add([
            'offer_name' => $currentBestOffer['name'],
            'quantity' => $numberOfBestQuantity,
            'percent' => $currentBestOffer['discountPercent'],
            'price' => $currentBestOffer['price'] * $numberOfBestCurrentOfferUsage
        ]);
        if ($retain > 1 && $retain >= $minOfferQuantity) {
            return $this->getBestPriceByRepeatCount($product, $offerDiscountCollection, $retain, $currentState);
        } elseif ($retain != 0) {
            $currentState->add([
                'offer_name' => 'without',
                'quantity' => $retain,
                'percent' => 0,
                'price' => $product->unit_price * $retain
            ]);
        }

        return $currentState;
    }

    /**
     * @param Collection $state
     * @return float|int
     */
    private function calculateStateDiscount(Collection $state)
    {
        $firstStateResult = 0;
        $state->each(function ($state) use (&$firstStateResult) {
            $firstStateResult += $state['quantity'] * $state['percent'];
        });

        return $firstStateResult / $state->sum('quantity');
    }
}
