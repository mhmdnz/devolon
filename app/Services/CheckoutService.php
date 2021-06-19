<?php

namespace App\Services;

use App\Http\DTO\CheckoutBestOfferDTO;
use App\Http\DTO\CheckoutDTO;
use App\Http\DTO\CheckoutDTOInterface;
use App\Http\DTO\OfferDiscountDTO;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Interfaces\CheckoutServiceInterface;
use Illuminate\Support\Collection;

class CheckoutService implements CheckoutServiceInterface
{
    const WITHOUT_OFFER_NAME = 'Without Offer';

    public function __construct(
        private ProductRepositoryInterface $productRepository
    )
    {
    }

    public function calculateCheckout(array $productIds): CheckoutDTOInterface
    {
        $productIdCollection = collect($productIds);
        $uniqueProducts = $productIdCollection->groupBy('id');
        $checkoutDTO = new CheckoutDTO();
        $bestPrice= 0;
        $priceWithoutDiscount = 0;
        $offers = [];
        $uniqueProducts->each(function ($content, $productId) use (&$bestPrice, &$priceWithoutDiscount, &$offers){
            $product = $this->productRepository->find($productId);
            $priceWithoutDiscount += ($product->unit_price * count($content));
            $productBestPrice = $this->getBestPrice($product, count($content));
            $bestPrice += $productBestPrice->sum('price');
            $offers[$product->name] = $productBestPrice;
        });
        $checkoutDTO->setPrice($bestPrice);
        $checkoutDTO->setPriceWithoutDiscount($priceWithoutDiscount);
        $checkoutDTO->setDiscount($priceWithoutDiscount - $bestPrice);
        $checkoutDTO->setOffers($offers);

        return $checkoutDTO;
    }

    public function getBestPrice(Product $product, $repeatCount): Collection
    {
        if ($repeatCount == 1) {
            return $this->getWithoutOfferStateCollection($repeatCount, $product);
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
            $offerDiscountDTO = new OfferDiscountDTO();
            $offerDiscountDTO->setOfferId($offer->id);
            $offerDiscountDTO->setOfferName($offer->name);
            $offerDiscountDTO->setPrice($offer->price);
            $offerDiscountDTO->setQuantity($offer->quantity);
            $offerDiscountDTO->setDiscountPercent(100 - (($offer->price * 100) / ($product->unit_price * $offer->quantity)));
            $offersDiscountCollection->add($offerDiscountDTO);
        });

        return $offersDiscountCollection;
    }

    private function findBestOffer(Product $product, $offerDiscountCollection, $repeatCount): Collection
    {
        $currentBestOffer = $offerDiscountCollection->where('quantity', '<=', $repeatCount)->sortByDesc('discountPercent')->first();
        if (!$currentBestOffer) {
            return $this->getWithoutOfferStateCollection($repeatCount, $product);
        }
        $finalState = $this->getBestPriceByRepeatCount($product, $offerDiscountCollection, $repeatCount, $currentBestOffer);
        $result = $this->calculateStateDiscount($finalState);
        $checkedBestOffers[] = $currentBestOffer->id;
        while ($result < $offerDiscountCollection->whereNotIn('id', $checkedBestOffers)->max('discountPercent')) {
            $currentBestOffer = $offerDiscountCollection->where('quantity', '<=', $repeatCount)->whereNotIn('id', $checkedBestOffers)->sortByDesc('discountPercent')->first();
            $checkedBestOffers[] = $currentBestOffer->id;
            if ($currentBestOffer) {
                $finalState = $this->getBestPriceByRepeatCount($product, $offerDiscountCollection, $repeatCount, $currentBestOffer);
                $newResult = $this->calculateStateDiscount($finalState);
                if ($newResult > $result) {
                    $result = $newResult;
                }
                $offerDiscountCollection = $offerDiscountCollection->reject(function ($item, $value) use ($currentBestOffer) {
                    return $item->id == $currentBestOffer->id;
                });
            }
        }

        return $finalState;
    }

    private function getBestPriceByRepeatCount(
        Product $product,
        $offerDiscountCollection,
        $repeatCount,
        $currentBestOffer,
        $currentState = null
    ): Collection
    {
        $minOfferQuantity = $offerDiscountCollection->min('quantity');
        $numberOfBestCurrentOfferUsage = floor($repeatCount / $currentBestOffer->quantity);
        $numberOfBestQuantity = $numberOfBestCurrentOfferUsage * $currentBestOffer->quantity;
        $retain = $repeatCount - $numberOfBestQuantity;
        if (!$currentState) {
            $currentState = collect();
        }
        $newState = new CheckoutBestOfferDTO();
        $newState->setOfferName($currentBestOffer->offerName);
        $newState->setQuantity($numberOfBestQuantity);
        $newState->setPrice($currentBestOffer->price * $numberOfBestCurrentOfferUsage);
        $newState->setDiscountPercent($currentBestOffer->discountPercent);
        $currentState->add($newState);
        if ($retain > 1 && $retain >= $minOfferQuantity) {
            $currentBestOffer = $offerDiscountCollection->where('quantity', '<=', $retain)
                ->sortByDesc('discountPercent')
                ->first();

            return $this->getBestPriceByRepeatCount($product, $offerDiscountCollection, $retain, $currentBestOffer, $currentState);
        } elseif ($retain != 0) {
            $withoutOfferState = new CheckoutBestOfferDTO();
            $withoutOfferState->setOfferName(self::WITHOUT_OFFER_NAME);
            $withoutOfferState->setQuantity($retain);
            $withoutOfferState->setPrice($product->unit_price * $retain);
            $withoutOfferState->setDiscountPercent(0);
            $currentState->add($withoutOfferState);
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
            $firstStateResult += $state->quantity * $state->discountPercent;
        });

        return $firstStateResult / $state->sum('quantity');
    }

    /**
     * @param $repeatCount
     * @param Product $product
     * @return Collection
     */
    private function getWithoutOfferStateCollection($repeatCount, Product $product): Collection
    {
        $withoutOfferState = new CheckoutBestOfferDTO();
        $withoutOfferState->setOfferName(self::WITHOUT_OFFER_NAME);
        $withoutOfferState->setQuantity($repeatCount);
        $withoutOfferState->setPrice($repeatCount * $product->unit_price);
        $withoutOfferState->setDiscountPercent(0);

        return collect($withoutOfferState);
    }
}
