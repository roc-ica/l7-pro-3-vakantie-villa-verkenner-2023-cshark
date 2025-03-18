<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HouseRequestLog extends Model
{
    use HasFactory;

    protected $table = 'house_request_logs';

    protected $fillable = [
        'house_object_id',
        'email',
        'message',
        'completed',
    ];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class, 'house_object_id', 'id');
    }
}