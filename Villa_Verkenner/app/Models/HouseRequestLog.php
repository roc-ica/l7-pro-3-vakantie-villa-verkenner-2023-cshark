<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $casts = [
        'completed' => 'boolean',
    ];

    public function house()
    {
        return $this->belongsTo(House::class, 'house_object_id');
    }
}