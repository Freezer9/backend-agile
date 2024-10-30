<?php

namespace App\Models;

use AgileTeknik\Auth\AgileTeknikAuthUser;
use AgileTeknik\Auth\HasAgileTeknikAuth;
use AgileTeknik\Storage\AgileTeknikMedia;
use AgileTeknik\Storage\HasAgileTeknikMedia;
use App\Enum\EMediaCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable implements AgileTeknikAuthUser, AgileTeknikMedia
{
    use HasFactory, Notifiable, HasAgileTeknikAuth, HasAgileTeknikMedia;

    protected $fillable = [
        'name',
        'email',
        'password',
        'goal',
    ];

    protected $hidden = [
        'password',
        'media',
        'remember_token',
    ];

    protected $appends = [
        'profile_image',
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

    public function favorites()
    {
        return $this->hasMany(UserFavorite::class, 'user_id', 'id');
    }

    protected function profileImage(): Attribute
    {
        return Attribute::make(
            get: function () {
                $mediaURL = $this->getFirstMediaUrl(EMediaCollection::USER_PROFILE_THUMBNAIL->value);
                return ! empty($mediaURL) ? $mediaURL : null;
            }
        );
    }
}
