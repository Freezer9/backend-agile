<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use App\Models\ServerRecipe;

class ServerRecipesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = new Client(['verify' => false]);
        $response = $client->get("https://raw.githubusercontent.com/Freezer9/My-Dataset/refs/heads/main/JSON/data/data_mangan.json");
        $recipes = json_decode($response->getBody()->getContents());
        foreach ($recipes as $recipeData) {
            ServerRecipe::create([
                'nama' => $recipeData->nama,
                'bahan' => $recipeData->bahan,
                'kalori' => $recipeData->calories,
                'karbohidrat' => $recipeData->karbohidrat,
                'protein' => $recipeData->protein,
                'lemak' => $recipeData->lemak,
                'link' => $recipeData->link,
                'goal' => $recipeData->goal,
                'waktu' => $recipeData->waktu,
            ]);
        }
    }
}
