<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Motorcycle extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_SOLD = 'sold';
    public const STATUS_INACTIVE = 'inactive';

    public const TRANSMISSION_MANUAL = 'Manual';
    public const TRANSMISSION_AUTOMATIC = 'Automatic';
    public const TRANSMISSION_SEMI_AUTOMATIC = 'Semi-Automatic';

    protected $fillable = [
        'brand_id',
        'created_by',
        'model',
        'year',
        'price',
        'mileage',
        'engine_capacity',
        'transmission',
        'color',
        'description',
        'status',
        'published_at',
        'sold_at',
    ];

    protected $casts = [
        'year' => 'integer',
        'price' => 'decimal:2',
        'mileage' => 'integer',
        'engine_capacity' => 'integer',
        'published_at' => 'datetime',
        'sold_at' => 'datetime',
    ];

    /**
     * Get the brand of the motorcycle.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the user/employee who created the product.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all images for the motorcycle.
     */
    public function images(): HasMany
    {
        return $this->hasMany(MotorcycleImage::class)
            ->orderByDesc('is_primary')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * Get the primary image of the motorcycle.
     */
    public function primaryImage(): HasOne
    {
        return $this->hasOne(MotorcycleImage::class)->where('is_primary', true);
    }

    /**
     * Scope a query to only include published motorcycles.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    /**
     * Scope a query to filter motorcycles based on request criteria.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        // Keyword Search
        if (!empty($filters['search'])) {
            $keyword = trim($filters['search']);
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('model', 'LIKE', "%{$keyword}%")
                  ->orWhere('color', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%")
                  ->orWhereHas('brand', function (Builder $bq) use ($keyword) {
                      $bq->where('name', 'LIKE', "%{$keyword}%");
                  });
            });
        }

        // Filter Brand
        if (!empty($filters['brand_id'])) {
            $query->where('brand_id', $filters['brand_id']);
        }

        // Filter Status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter Min & Max Price (gracefully handles edge case where min_price > max_price)
        $minPrice = !empty($filters['min_price']) ? (float) $filters['min_price'] : null;
        $maxPrice = !empty($filters['max_price']) ? (float) $filters['max_price'] : null;

        if ($minPrice !== null && $maxPrice !== null && $minPrice > $maxPrice) {
            [$minPrice, $maxPrice] = [$maxPrice, $minPrice];
        }

        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        // Filter Min & Max Year (gracefully handles edge case where min_year > max_year)
        $minYear = !empty($filters['min_year']) ? (int) $filters['min_year'] : null;
        $maxYear = !empty($filters['max_year']) ? (int) $filters['max_year'] : null;

        if ($minYear !== null && $maxYear !== null && $minYear > $maxYear) {
            [$minYear, $maxYear] = [$maxYear, $minYear];
        }

        if ($minYear !== null) {
            $query->where('year', '>=', $minYear);
        }

        if ($maxYear !== null) {
            $query->where('year', '<=', $maxYear);
        }

        // Filter Transmission
        if (!empty($filters['transmission'])) {
            $query->where('transmission', $filters['transmission']);
        }

        // Sorting
        $sort = $filters['sort'] ?? 'latest';
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'year_desc' => $query->orderBy('year', 'desc'),
            'year_asc' => $query->orderBy('year', 'asc'),
            'mileage_asc' => $query->orderBy('mileage', 'asc'),
            default => $query->latest('id'),
        };

        return $query;
    }

    /**
     * Get the full title (Brand + Model + Year).
     */
    public function getTitleAttribute(): string
    {
        $brandName = $this->brand ? $this->brand->name : '';
        return trim("{$brandName} {$this->model} {$this->year}");
    }

    /**
     * Get the formatted price in IDR currency.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get formatted mileage in kilometers.
     */
    public function getFormattedMileageAttribute(): string
    {
        return number_format($this->mileage, 0, ',', '.') . ' km';
    }

    /**
     * Get primary or first image URL.
     */
    public function getMainImageUrlAttribute(): string
    {
        $primary = $this->primaryImage ?: $this->images->first();

        if ($primary && $primary->url) {
            return $primary->url;
        }

        return asset('images/placeholder-motor.svg');
    }

    /**
     * Build the WhatsApp inquiry link.
     */
    public function getWhatsappUrlAttribute(): string
    {
        $number = config('showroom.whatsapp_number', '6281234567890');
        $cleanNumber = preg_replace('/[^0-9]/', '', $number);

        $message = "Halo, saya tertarik dengan motor berikut:\n\n"
            . "Motor: {$this->title}\n"
            . "Harga: {$this->formatted_price}\n\n"
            . "Apakah motor ini masih tersedia?";

        return 'https://wa.me/' . $cleanNumber . '?text=' . rawurlencode($message);
    }

    /**
     * Check if product is sold.
     */
    public function isSold(): bool
    {
        return $this->status === self::STATUS_SOLD;
    }

    /**
     * Check if product is published.
     */
    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }
}
