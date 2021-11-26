<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
