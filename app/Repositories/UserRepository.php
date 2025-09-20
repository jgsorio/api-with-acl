<?php

namespace App\Repositories;

use App\Dto\Users\CreateUserDTO;
use App\Dto\Users\UpdateUserDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function __construct(protected User $model) {}

    public function all(string $filter = ''): LengthAwarePaginator
    {
        return $this->model->when($filter, function ($query, $filter) {
            return $query->where('name', 'like', "%{$filter}%")
                ->orWhere('email', 'like', "%{$filter}%");
        })->paginate();
    }

    public function create(CreateUserDTO $input): User
    {
        return $this->model->create((array)$input);
    }

    public function findById(string $id): ?User
    {
        $user = $this->model->where('id', $id)->first();
        return $user ?? null;
    }

    public function update(UpdateUserDTO $input, User $user): User
    {
        $user->update([
            'name' => $input->name ?? $user->name,
            'email' => $input->email ?? $user->email,
            'password' => $input->password ?? $user->password
        ]);
        return $user;
    }

    public function delete(string $id): bool
    {
        return $this->model->where('id', $id)->delete();
    }
}
