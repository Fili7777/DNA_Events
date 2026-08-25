<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

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

    public function store(StoreUserRequest $request)
    {
        $user = $this->userRepository->create($request->validated());

        return (new UserResource($user))
                ->response()
                ->setStatusCode(201);
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        $user = $this->userRepository->update($id, $request->validated());

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