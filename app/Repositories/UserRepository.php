<?php

namespace App\Repositories;

use App\Models\User;


class UserRepository
{
    public function getAll(array $relations = [])
    {
        return User::with($relations)->get();
    }

    public function getById(int $id, array $relations = [])
    {
        return User::with($relations)->findOrFail($id);
    }

    public function create(array $data)
    {
        
        return User::create($data);
    }

    public function update(int $id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);

        return $user;
    }

    public function delete(int $id)
    {
        return User::findOrFail($id)->delete();
    }
}
