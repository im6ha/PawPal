<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
    use  Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'trust_score',
        'status',
        'profile_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function products()
{
    return $this->hasMany(Product::class);
}

    public function savedPosts()
{
    return $this->hasMany(SavedPost::class);
}

    public function sentRequests()
{
    return $this->hasMany(ServiceRequest::class, 'sender_id');
}

public function receivedRequests()
{
    return $this->hasMany(ServiceRequest::class, 'receiver_id');
}
}