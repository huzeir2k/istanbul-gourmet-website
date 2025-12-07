<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'brand_id',
        'category_id',
        'price_cents',
        'currency',
        'short_description',
        'description',
        'stock',
        'track_inventory',
        'image',
        'images',
        'is_active',
    ];

    protected $casts = [
        'images' => 'array',
        'track_inventory' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected $appends = ['price_with_tax'];

    // Accessor: calculate price with 13% HST/GST (Ontario)
    public function getPriceWithTaxAttribute(): string
    {
        $basePrice = floatval($this->price);
        $taxedPrice = $basePrice * 1.13;
        return number_format($taxedPrice, 2, '.', '');
    }

    // Accessor: return price as formatted decimal string (dollars)
    public function getPriceAttribute(): string
    {
        return number_format($this->price_cents / 100, 2, '.', '');
    }

    // Mutator: accept decimal price like "12.99" and convert to cents
    public function setPriceAttribute($value): void
    {
        $this->attributes['price_cents'] = (int) round(floatval(str_replace(',', '.', $value)) * 100);
    }

    // Accessor: expose raw price_cents as integer
    public function getPriceCentsAttribute($value): int
    {
        return (int) $value;
    }

    // Relationships
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
