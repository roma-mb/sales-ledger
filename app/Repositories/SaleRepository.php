<?php

namespace App\Repositories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder;

class SaleRepository
{
    public function all()
    {
        return Sale::paginate(15);
    }

    public function save(array $attributes)
    {
        return Sale::firstOrCreate($attributes);
    }

    public function findWithRelation(Sale $sale, string $relation): Builder
    {
        return $sale
            ->with($relation)
            ->where('id', $sale->id);
    }

    public function update(array $attributes, Sale $sale): bool
    {
        return $sale->update($attributes);
    }

    public function destroy(Sale $sale): ?bool
    {
        return $sale->delete();
    }
}
