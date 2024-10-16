<?php

namespace App\Models;

use AgileTeknik\Storage\HasAgileTeknikMedia;
use AgileTeknik\Storage\AgileTeknikMedia;
use App\Enum\EMediaCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class UserRecipe extends Model implements AgileTeknikMedia
{
    use HasAgileTeknikMedia;


    protected $fillable = [
        'user_id',
        'server_recipe_id',
        'nama',
        'bahan',
        'link',
    ];

    protected $hidden = [
        'media',
        'updated_at'
    ];

    protected $appends = [
        'thumbnail_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $mediaURL = $this->getFirstMediaUrl(EMediaCollection::USER_RECIPE_THUMBNAIL->value);
                return ! empty($mediaURL) ? $mediaURL : null;
            }
        );
    }
}
