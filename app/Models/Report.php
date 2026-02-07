<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Report extends Model
{
    protected $fillable = ['reportable_id', 'post_type', 'status'];

    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }
}