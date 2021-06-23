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

    /**
     * This function will just call getBestPrice function for each product
     *
     * @param array $productIds
     * @return CheckoutDTOInterface
     */
    public function calculateCheckout(array $productIds): CheckoutDTOInterface
    {
        $productIdCollection = collect($productIds);
        $uniqueProducts = $productIdCollection->groupBy('id');
        $bestPrice= 0;
        $priceWithoutDiscount = 0;
        $offers = [];
        $uniqueProducts->each(function ($content, $productId) use (&$bestPrice, &$priceWithoutDiscount, &$offers){
            $product = $this->productRepository->findOrFail($productId);
            $priceWithoutDiscount += ($product->unit_price * count($content));
            $productBestPrice = $this->getBestPrice($product, count($content));
            $bestPrice += $productBestPrice->sum('price');
            $offers[$product->name] = $productBestPrice;
        });
        $checkoutDTO = new CheckoutDTO(
            $bestPrice > 0 ? $bestPrice : $priceWithoutDiscount,
            $bestPrice > 0 ? $priceWithoutDiscount - $bestPrice : 0,
            $offers,
            $priceWithoutDiscount
        );

        return $checkoutDTO;
    }

    /**
     * This function will initiate the processing data to find the best offer for the
     * given product according to number of repeat in checkout request
     *
     * @param Product $product
     * @param $repeatCount
     * @return Collection
     */
    private function getBestPrice(Product $product, $repeatCount): Collection
    {
        if ($repeatCount == 1) {
            return $this->getWithoutOfferStateCollection($repeatCount, $product);
        }

        $offers = $this->productRepository->getOffersByQuantityLimit($product, $repeatCount);
        $offerDiscountCollection = $this->getOffersDiscountCollection($offers, $product);

        return $this->findBestOffer($product, $offerDiscountCollection, $repeatCount);
    }

    /**
     * This function will calculate all offers discount percent according to current product price
     *
     * @param Collection $offers
     * @param Product $product
     * @return Collection
     */
    private function getOffersDiscountCollection(Collection $offers, Product $product): Collection
    {
        $offersDiscountCollection = collect();
        $offers->each(function ($offer) use ($offersDiscountCollection, $product) {
            $discountPercent = 100 - (($offer->price * 100) / ($product->unit_price * $offer->quantity));
            if ($discountPercent > 0) {
                $offerDiscountDTO = new OfferDiscountDTO(
                    $offer->id,
                    $offer->name,
                    $offer->quantity,
                    $discountPercent,
                    $offer->price
                );

                $offersDiscountCollection->add($offerDiscountDTO);
            }
        });

        return $offersDiscountCollection;
    }

    /**
     * This function is the one which decide the best(lowest) price from all the offer collections
     * and if find the highest discount, will return the result
     *
     * @param Product $product
     * @param $offerDiscountCollection
     * @param $repeatCount
     * @return Collection
     */
    private function findBestOffer(Product $product, $offerDiscountCollection, $repeatCount): Collection
    {
        $finalState = $this->getWithoutOfferStateCollection($repeatCount, $product);
        $checkedBestOffers = [];
        $result = 0;
        do {
            $currentBestOffer = $offerDiscountCollection->where('quantity', '<=', $repeatCount)->whereNotIn('id', $checkedBestOffers)->sortByDesc('discountPercent')->first();
            if ($currentBestOffer) {
                $checkedBestOffers[] = $currentBestOffer->id;
                $finalState = $this->findStateByGivenBestOffer($product, $offerDiscountCollection, $repeatCount, $currentBestOffer);
                $newResult = $this->calculateStateDiscount($finalState);
                if ($newResult > $result) {
                    $result = $newResult;
                }
                $offerDiscountCollection = $offerDiscountCollection->reject(function ($item) use ($currentBestOffer) {
                    return $item->id == $currentBestOffer->id;
                });
            }
        } while ($result < $offerDiscountCollection->whereNotIn('id', $checkedBestOffers)->max('discountPercent'));

        return $finalState;
    }

    /**
     * This function will calculate discount by starting from the given currentBestOffer
     * and send the result back to findBestOffer to be compared by the other results
     *
     * @param Product $product
     * @param $offerDiscountCollection
     * @param $repeatCount
     * @param $currentBestOffer
     * @param null $currentState
     * @return Collection
     */
    private function findStateByGivenBestOffer(
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
        $newState = new CheckoutBestOfferDTO(
            $currentBestOffer->offerName,
            $numberOfBestQuantity,
            $currentBestOffer->discountPercent,
            $currentBestOffer->price * $numberOfBestCurrentOfferUsage
        );
        $currentState->add($newState);
        if ($retain > 1 && $retain >= $minOfferQuantity) {
            $currentBestOffer = $offerDiscountCollection->where('quantity', '<=', $retain)
                ->sortByDesc('discountPercent')
                ->first();

            return $this->findStateByGivenBestOffer($product, $offerDiscountCollection, $retain, $currentBestOffer, $currentState);
        } elseif ($retain != 0) {
            $withoutOfferState = new CheckoutBestOfferDTO(
                self::WITHOUT_OFFER_NAME,
                $retain,
                0,
                $product->unit_price * $retain
            );

            $currentState->add($withoutOfferState);
        }

        return $currentState;
    }

    /**
     * This function will calculate the discount for the given state
     *
     * @param Collection $state
     * @return float|int
     */
    private function calculateStateDiscount(Collection $state)
    {
        $stateResult = 0;
        $state->each(function ($state) use (&$stateResult) {
            $stateResult += $state->quantity * $state->discountPercent;
        });

        return $stateResult / $state->sum('quantity');
    }

    /**
     * This function will just return a Without_offer_name CheckoutBestOfferDTO
     * for those are not be able to get any discount
     *
     * @param $repeatCount
     * @param Product $product
     * @return Collection
     */
    private function getWithoutOfferStateCollection($repeatCount, Product $product): Collection
    {
        $withoutOfferState = new CheckoutBestOfferDTO(
            self::WITHOUT_OFFER_NAME,
            $repeatCount,
            0,
            $repeatCount * $product->unit_price
        );

        return collect($withoutOfferState);
    }
}
