<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return UserResource::collection($this->userRepository->getAll(['tickets']));
    }

    public function show(int $id)
    {
        return new UserResource($this->userRepository->getById($id, ['tickets']));
    }

    public function store(Request $request)
    {
        $user = $this->userRepository->create($request->validate([
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
        $user = $this->userRepository->update($id, $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'surname' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,'.$id,
            'password' => 'sometimes|required|string|min:8',
        ]));

        return new UserResource($user);
    }
    public function destroy(int $id)
    {
        $this->userRepository->delete($id);

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}