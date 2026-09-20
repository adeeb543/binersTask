<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

public function studies(): HasMany
    {
        return $this->hasMany(Study::class);
    }

    // علاقة مورف للمناقشات التي أرسلها الأدمن
    public function discussions(): MorphMany
    {
        return $this->morphMany(ProjectDiscussion::class, 'sender');
    }

    // علاقة مورف للأنشطة التي قام بها الأدمن
    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'causer');
    }

}
