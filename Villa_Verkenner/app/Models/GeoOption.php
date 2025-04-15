<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GeoOption extends Model
{
    use HasFactory;

    protected $table = 'geo_option';

    protected $fillable = ['name'];

    public function houses(): BelongsToMany
    {
        return $this->belongsToMany(House::class, 'geo_option_house_object', 'geo_option_id', 'house_object_id');
    }
}