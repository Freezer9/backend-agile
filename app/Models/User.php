<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use AgileTeknik\Auth\AgileTeknikAuthUser;
use AgileTeknik\Auth\HasAgileTeknikAuth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements AgileTeknikAuthUser
{
    use HasFactory, Notifiable, HasAgileTeknikAuth;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function recipes()
    {
        return $this->hasMany(UserRecipe::class);
    }
}
