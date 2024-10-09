<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServerRecipe;
use AgileTeknik\API\Controller;

class ServerRecipeController extends Controller
{
    /**
     * DisplaySa listing of the resource.
     */
    public function index()
    {
        $serverrecipes = ServerRecipe::all();
        return $this->response->resource($serverrecipes);
    }

    public function show(string $id)
    {
        $serverrecipe = ServerRecipe::find($id);
        return $this->response->resource($serverrecipe);
    }
}
