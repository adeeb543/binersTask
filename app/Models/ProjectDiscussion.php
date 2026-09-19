<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ProjectDiscussion extends Model
{
    protected $guarded = [];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // علاقة الـ Morph العكسية لمعرفة المرسل (Admin أو User)
    public function sender(): MorphTo
    {
        return $this->morphTo();
    }
}
