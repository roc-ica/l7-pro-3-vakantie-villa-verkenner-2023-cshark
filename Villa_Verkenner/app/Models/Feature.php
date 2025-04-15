<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feature extends Model
{
    use HasFactory;

    protected $table = 'feature';

    protected $fillable = ['name'];

    public function houses(): BelongsToMany
    {
        return $this->belongsToMany(House::class, 'feature_house_object', 'feature_id', 'house_object_id');
    }
}