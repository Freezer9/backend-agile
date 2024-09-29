<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRecipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'server_recipe_id',
        'nama',
        'bahan',
        'kalori',
        'karbohidrat',
        'protein',
        'lemak',
        'link',
        'goal',
        'waktu',
    ];
}
