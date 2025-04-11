<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HouseImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_object_id',
        'image_path',
        'is_primary',
        'display_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class, 'house_object_id');
    }
}
