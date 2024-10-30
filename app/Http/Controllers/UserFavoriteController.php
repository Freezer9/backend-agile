<?php

namespace App\Http\Controllers;

use App\Models\User;
use AgileTeknik\API\Controller;
use App\Models\UserFavorite;
use Illuminate\Http\Request;

class UserFavoriteController extends Controller
{
    public function index($id)
    {
        $favorites = UserFavorite::where('user_id', $id)->get()->map(function ($favorite) {
            return $favorite->recipe;
        });

        return $this->response->resource($favorites);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'recipe_id' => 'required|integer',
        ]);

        $user = User::with('favorites')->find($request->user_id);

        if (!$user) {
            return $this->response->error('User not found', 404);
        }

        $favoriteExists = $user->favorites->contains('recipe_id', $request->recipe_id);

        if ($favoriteExists) {
            return $this->response->error('Favorite already exists', 400);
        }

        $favorite = new UserFavorite();
        $favorite->user_id = $request->user_id;
        $favorite->recipe_id = $request->recipe_id;
        $favorite->save();

        return $this->response->resource($favorite);
    }

    public function destroy($userId, $id)
    {
        $favorite = UserFavorite::where('user_id', $userId)->where('recipe_id', $id)->first();

        if (!$favorite) {
            return $this->response->error('Favorite not found', 404);
        } else {
            $favorite->delete();
        }

        return $this->response->resource($favorite);
    }
}
