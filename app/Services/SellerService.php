<?php

namespace App\Services;

use App\Exceptions\SellerExceptions;
use App\Models\Seller;
use App\Repositories\SellerRepository;
use Illuminate\Support\Collection;

class SellerService
{
    private SellerRepository $sellerRepository;

    public function __construct(SellerRepository $sellerRepository)
    {
        $this->sellerRepository = $sellerRepository;
    }

    public function getAll()
    {
        return $this->sellerRepository->all()->transform(static function ($seller) {
            return [
                'id'         => $seller->id,
                'name'       => $seller->name,
                'email'      => $seller->email,
                'commission' => round($seller->sales->sum('commission'), 2),
            ];
        });
    }

    /**
     * @throws \Throwable
     */
    public function store(array $attributes): Seller
    {
        $seller = $this->sellerRepository->save($attributes);

        throw_unless(($seller instanceof Seller), SellerExceptions::sellerHasNotBeenSaved());

        return $seller;
    }

    public function find(Seller $seller): Collection
    {
        return $this->sellerRepository->findWithRelation($seller, 'sales')->get();
    }

    public function update(array $all, Seller $seller): bool
    {
        return $this->sellerRepository->update($all, $seller);
    }

    public function delete(Seller $seller): ?bool
    {
        return $this->sellerRepository->destroy($seller);
    }
}
