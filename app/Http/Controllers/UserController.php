<?php

namespace App\Http\Controllers;
use App\Models\User;
use AgileTeknik\API\Controller;
use Illuminate\Http\Request;


 
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
        $user = User::find($id);
        $user->update($request->all());
        return $this->response->resource($user);
    }

    public function destroy(int $id)
    {
        $user = User::find($id);
        $user->delete();
        return $this->response->resource($user);
    }
}


