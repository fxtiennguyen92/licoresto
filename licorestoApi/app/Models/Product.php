<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

#[ScopedBy([ActiveScope::class])]
#[ScopedBy([PublishedScope::class])]
class Product extends Model
{
    use HasFactory;
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'discount_flg' => 'boolean',
            'featured_flg' => 'boolean',
            'popular_flg' => 'boolean',
            'published_flg' => 'boolean',
            'active_flg' => 'boolean',
        ];
    }

    public function scopeDiscount(Builder $query): void
    {
        $query->where('discount_flg', true);
    }

    public function scopeFeatured(Builder $query): void
    {
        $query->where('featured_flg', true);
    }

    public function scopePopular(Builder $query): void
    {
        $query->where('popular_flg', true);
    }


}
