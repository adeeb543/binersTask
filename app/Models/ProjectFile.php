<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectFile extends Model
{
    protected $fillable = [
        'project_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }


    protected function filePath(): Attribute
{
    return Attribute::make(
        get: fn ($value) => $value ? asset('storage/' . $value) : null,
    );
}
}
