<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function discussions(): HasMany
    {
        return $this->hasMany(ProjectDiscussion::class);
    }

    public function study(): HasOne
    {
        return $this->hasOne(Study::class);
    }

    public function quotation(): HasOne
    {
        return $this->hasOne(Quotation::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
