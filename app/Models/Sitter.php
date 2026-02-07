<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasWilaya;

class Sitter extends Model
{
    use HasFactory, HasWilaya;

    protected $fillable = [
        'user_id',
        'location',
        'fee_per_day',
        'bio',
        'profile_image_path',
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