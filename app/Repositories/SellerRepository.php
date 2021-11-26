<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Seller;
use Illuminate\Database\Eloquent\Builder;

class SellerRepository
{
    public function all()
    {
        return Seller::all();
    }

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

    public function update(array $all, Seller $seller): bool
    {
        return $seller->update($all);
    }

    public function destroy(Seller $seller): ?bool
    {
        return $seller->delete();
    }
}
