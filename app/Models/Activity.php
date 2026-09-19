<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    protected $guarded = [];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // علاقة الـ Morph العكسية لمعرفة من تسبب بالحدث
    public function causer(): MorphTo
    {
        return $this->morphTo();
    }
}
