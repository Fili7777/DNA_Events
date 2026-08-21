<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::with('tickets')->get());
    }

    public function show(int $id)
    {
        $user = User::with('tickets')->findOrFail($id);
        return new UserResource($user);
    }

    public function store(Request $request)
    {
        $user = User::create($request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]));

        return (new UserResource($user))
                ->response()
                ->setStatusCode(201);
    }

    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->validate([
            'name' => 'sometimes|required|string|max:255',
            'surname' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,'.$id,
            'password' => 'sometimes|required|string|min:8',
        ]));

        return new UserResource($user);
    }

    public function destroy(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}