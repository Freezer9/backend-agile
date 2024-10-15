<?php

namespace App\Http\Controllers;

use App\Models\User;
use AgileTeknik\API\Controller;
use App\enum\EMediaCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return $this->response->resource($users);
    }

    public function show(int $id)
    {
        $user = User::find($id);
        return $this->response->resource($user);
    }

    public  function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return $this->response->resource($user);
    }

    public function update(Request $request, int $id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            return $this->response->error('User not found.', 404);
        }

        $validateUser = $request->validate([
            'name' => 'required',
            'email' => 'nullable',
            'password' => 'nullable',
            'goal' => 'required',
            'profile_image' => 'nullable|image',
        ]);
        if ($request->hasFile('profile_image')) {
            $media = $user->getMedia(EMediaCollection::USER_PROFILE_THUMBNAIL->value)
                ->where('model_id', $user->id)
                ->first();
            if ($media) {
                $media->delete();
            }
            $user->saveMedia(EMediaCollection::USER_PROFILE_THUMBNAIL, $validateUser['profile_image']);
        }
        $user->update(Arr::except($validateUser, 'profile_image'));
        $user->load('media');
        
        return $this->response->resource($user);
    }

    public function destroy(int $id)
    {
        $user = User::find($id);
        $user->delete();
        return $this->response->resource($user);
    }
}
