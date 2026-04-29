<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

        protected $fillable = [
        'category_id',
        'name',
        'slug',
        'producer',
        'description',
        'image',
        'price',
        'wine_type',
        'grape',
        'country',
        'region',
        'appellation',
        'vintage_year',
        'volume_ml',
        'alcohol_percentage',
        'stock',
        'condition',
        'rating_source',
        'rating_score',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'alcohol_percentage' => 'decimal:1',
        'rating_score' => 'decimal:1',
        'is_featured' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}