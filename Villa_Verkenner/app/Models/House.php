<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class House extends Model
{
    use HasFactory;

    protected $table = 'house_object';

    protected $fillable = [
        'name',
        'description',
        'image',
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
}