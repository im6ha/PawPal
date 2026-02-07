<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasWilaya;

class Product extends Model
{
    use HasWilaya;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'category',
        'pet_type',
        'location',
        'image_path',
        'status'
    ];

    protected $appends = ['wilaya_name'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function serviceRequests()
{
    return $this->morphMany(ServiceRequest::class, 'requestable');
}
}