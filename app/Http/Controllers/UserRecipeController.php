<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRecipe;
use AgileTeknik\API\Controller;

class UserRecipeController extends Controller
{
    public function index()
    {
        $userrecipes = UserRecipe::all();
        return $this->response->resource($userrecipes);
    }


    public function store(Request $request)
    {
        $userrecipe = UserRecipe::create($request->all());
        return $this->response->resource($userrecipe);
    }

    public function show(string $id)
    {
        $userrecipe = UserRecipe::find($id);
        return $this->response->resource($userrecipe);
    }

    public function update(Request $request, string $id)
    {
        $userrecipe = UserRecipe::find($id);
        $userrecipe->update($request->all());
        return $this->response->resource($userrecipe);
    }

    public function destroy(string $id)
    {
        $userrecipe = UserRecipe::find($id);
        $userrecipe->delete();
        return $this->response->resource($userrecipe);
    }
}
