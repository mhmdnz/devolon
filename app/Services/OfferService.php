<?php


namespace App\Services;


use App\Repositories\Interfaces\MainRepositoryInterface;
use App\Repositories\Interfaces\OfferRepositoryInterface;
use App\Services\Interfaces\OfferServiceInterface;

class OfferService extends MainService implements OfferServiceInterface
{
    public function __construct(protected OfferRepositoryInterface $offerRepository)
    {
    }

    public function setRepository(): MainRepositoryInterface
    {
        return $this->offerRepository;
    }
}
