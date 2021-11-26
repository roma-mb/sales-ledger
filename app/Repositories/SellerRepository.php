<?php

namespace App\Repositories;

use App\Models\Seller;
use Illuminate\Database\Eloquent\Builder;

class SellerRepository
{
    public function all()
    {
        return Seller::all();
    }

    /** @param mixed[] $attributes */
    public function save(array $attributes): Seller
    {
        return Seller::firstOrCreate($attributes);
    }

    public function findWithRelation(Seller $seller, string $relation): Builder
    {
        return $seller
            ->with($relation)
            ->where('id', $seller->id);
    }

    /** @param mixed[] $attributes */
    public function update(array $attributes, Seller $seller): bool
    {
        return $seller->update($attributes);
    }

    public function destroy(Seller $seller): ?bool
    {
        return $seller->delete();
    }
}
