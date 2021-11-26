<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'description',
        'value',
        'commission',
        'seller_id',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function scopeCreatedToday(Builder $query)
    {
        return $query->where('created_at', '>=', Carbon::today()->subDay()->format('Y-m-d H:i:s'));
    }
}
