<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SavedPost extends Model
{
    protected $fillable = ['user_id', 'saveable_type', 'saveable_id'];

    public function saveable(): MorphTo
    {
        return $this->morphTo();
    }
}