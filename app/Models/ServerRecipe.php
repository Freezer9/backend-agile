<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServerRecipe extends Model
{
    use HasFactory;
    protected $table = 'server_recipes';

    protected $fillable = [
        'nama',
        'bahan',
        'kalori',
        'karbohidrat',
        'protein',
        'lemak',
        'link',
        'goal',
        'waktu',
        'foto',
    ];

}
