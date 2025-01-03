<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use App\Models\ServerRecipe;
use Illuminate\Support\Facades\DB;

class ServerRecipesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // refresh server_recipes table 
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ServerRecipe::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $client = new Client(['verify' => false]);
        $response = $client->get("https://script.google.com/macros/s/AKfycbwhjscgOAire_JbuvveQN1-iEQ-ZMKPd8so56BlfWa3y9Bk1p5rOhZsbKgyeIa4tDM/exec");
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
                'foto' => $recipeData->foto,
                'goal' => $recipeData->goal,
                'jenis' => $recipeData->jenis,
                'waktu' => $recipeData->waktu,
            ]);
        }
    }
}
