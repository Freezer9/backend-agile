<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRecipe;
use AgileTeknik\API\Controller;
use App\enum\EMediaCollection;
use Illuminate\Support\Arr;

class UserRecipeController extends Controller
{
    public function index()
    {
        $userrecipes = UserRecipe::with('user')->get();
        return $this->response->resource($userrecipes);
    }


    public function store(Request $request)
    {
        $validateRequstData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama' => 'required',
            'bahan' => 'required',
            'link' => 'required',
            'thumbnail' => 'required|image',
        ]);

        $userrecipe = UserRecipe::create(Arr::except($validateRequstData, 'thumbnail'));
        $userrecipe->saveMedia(EMediaCollection::USER_RECIPE_THUMBNAIL, $validateRequstData['thumbnail']);
        $userrecipe->load('media', 'user');
        return $this->response->resource($userrecipe);
    }


    public function show(string $id)
    {
        $userrecipe = UserRecipe::with('user')->find($id);
        return $this->response->resource($userrecipe);
    }

    public function update(Request $request, string $id)
    {
        $userrecipe = UserRecipe::find($id);

        if (!$userrecipe) {
            return $this->response->error('User recipe not found.', 404);
        }

        $validateRequstData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama' => 'required',
            'bahan' => 'required',
            'link' => 'required',
            'thumbnail' => 'required|image',
        ]);

        $userrecipe->update(Arr::except($validateRequstData, 'thumbnail'));
        $userrecipe->saveMedia(EMediaCollection::USER_RECIPE_THUMBNAIL, $validateRequstData['thumbnail']);
        $userrecipe->load('media', 'user');
        return $this->response->resource($userrecipe);
    }

    public function destroy(string $id)
    {
        $userrecipe = UserRecipe::find($id);

        if (!$userrecipe) {
            return $this->response->error('User recipe not found.', 404);
        }

        $userrecipe->delete();
        return $this->response->resource($userrecipe->load('user'));
    }
}
