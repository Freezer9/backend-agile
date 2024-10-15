<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRecipe;
use AgileTeknik\API\Controller;
use App\enum\EMediaCollection;
use Illuminate\Support\Arr;

class UserRecipeController extends Controller
{
    public function index($id)
    {
        $userrecipes = UserRecipe::with('user')->where('user_id', $id)->get();
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
        $userrecipe->load('media');
        return $this->response->resource($userrecipe);
    }


    public function show(string $userId, string $id)
    {
        $userrecipe = UserRecipe::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$userrecipe) {
            return $this->response->error('User recipe not found.', 404);
        }

        return $this->response->resource($userrecipe);
    }


    public function update(Request $request, string $id)
    {

        $userrecipe = UserRecipe::where('id', $id)->first();
        if (!$userrecipe) {
            return $this->response->error('User recipe not found.', 404);
        }
        $validateRequestData = $request->validate([
            'nama' => 'required',
            'bahan' => 'required',
            'link' => 'required',
            'thumbnail' => 'nullable|image',
        ]);
        if ($request->hasFile('thumbnail')) {
            $media = $userrecipe->getMedia(EMediaCollection::USER_RECIPE_THUMBNAIL->value)
                ->where('model_id', $userrecipe->id)
                ->first();
            if ($media) {
                $media->delete();
            }
            $userrecipe->saveMedia(EMediaCollection::USER_RECIPE_THUMBNAIL, $validateRequestData['thumbnail']);
        }
        $userrecipe->update(Arr::except($validateRequestData, 'thumbnail'));
        $userrecipe->load('media');

        return $this->response->resource($userrecipe);
    }


    public function destroy(string $id)
    {
        $userrecipe = UserRecipe::where('id', $id)->first();

        if (!$userrecipe) {
            return $this->response->error('User recipe not found.', 404);
        }

        $media = $userrecipe->getMedia(EMediaCollection::USER_RECIPE_THUMBNAIL->value)
            ->where('model_id', $userrecipe->id)
            ->first();

        if ($media) {
            $media->delete();
        }

        $userrecipe->delete();

        return $this->response->resource($userrecipe->load('media', 'user'));
    }
}
