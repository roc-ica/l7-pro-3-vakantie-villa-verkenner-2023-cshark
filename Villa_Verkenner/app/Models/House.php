<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class House extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'house_object';

    protected $fillable = [
        'name',
        'description',
        'image', // Keeping for backward compatibility
        'price',
        'address',
        'status',
        'rooms',
        'popular',
    ];

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'feature_house_object', 'house_object_id', 'feature_id');
    }

    public function geoOptions(): BelongsToMany
    {
        return $this->belongsToMany(GeoOption::class, 'geo_option_house_object', 'house_object_id', 'geo_option_id');
    }

    public function requestLogs(): HasMany
    {
        return $this->hasMany(HouseRequestLog::class, 'house_object_id', 'id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(HouseImage::class, 'house_object_id', 'id')->orderBy('display_order');
    }

    public function getPrimaryImageAttribute()
    {
        $primaryImage = $this->images()->where('is_primary', true)->first();
        
        if ($primaryImage) {
            return $primaryImage->image_path;
        }
        
        // Fallback to first image or old image field
        return $this->images()->first()?->image_path ?? $this->image ?? 'houses/defaultImage.webp';
    }
}