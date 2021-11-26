<?php

namespace App\Services;

use App\Enumerations\Commission;
use App\Exceptions\SaleExceptions;
use App\Models\Sale;
use App\Repositories\SaleRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class SaleService
{
    private SaleRepository $saleRepository;

    public function __construct(SaleRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function getAll()
    {
        return $this->saleRepository->all();
    }

    /**
     * @param mixed[] $attributes
     *
     * @throws \Throwable
     */
    public function store(array $attributes)
    {
        $sale = $this->saleRepository->save(self::setCommission($attributes));

        throw_unless(($sale instanceof Sale), SaleExceptions::saleHasNotBeenSaved());

        return $sale->with('seller')->latest()->first();
    }

    public function find(Sale $sale): Collection
    {
        return $this->saleRepository->findWithRelation($sale, 'seller')->get();
    }

    /** @param mixed[] $attributes */
    public function update(array $attributes, Sale $sale): bool
    {
        return $this->saleRepository->update(self::setCommission($attributes), $sale);
    }

    public function delete(Sale $sale): ?bool
    {
        return $this->saleRepository->destroy($sale);
    }

    /** @param mixed[] $attributes */
    public static function setCommission(array $attributes): array
    {
        if ($value = Arr::get($attributes, 'value')) {
            $attributes['commission'] = Commission::applyPercentage($value);
        }

        return $attributes;
    }
}
