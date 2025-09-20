<?php

namespace App\Repositories;

use App\Dto\Permissions\CreatePermissionDTO;
use App\Dto\Permissions\UpdatePermissionDTO;
use App\Models\Permission;
use Illuminate\Pagination\LengthAwarePaginator;

class PermissionRepository
{
    public function __construct(protected Permission $model) {}

    public function all(?string $filter = ''): LengthAwarePaginator
    {
        return $this->model->when($filter, function ($query, $filter) {
            return $query->where('name', 'like', "%{$filter}%")
                ->orWhere('description', 'like', "%{$filter}%");
        })->paginate();
    }

    public function create(CreatePermissionDTO $input): Permission
    {
        return $this->model->create((array)$input);
    }

    public function findById(string $id): ?Permission
    {
        $permission = $this->model->where('id', $id)->first();
        return $permission ?? null;
    }

    public function update(UpdatePermissionDTO $input, Permission $permission): Permission
    {
        $permission->update([
            'name' => $input->name ?? $permission->name,
            'description' => $input->description ?? $permission->description
        ]);

        return $permission;
    }

    public function delete(string $id): bool
    {
        return $this->model->where('id', $id)->delete();
    }
}
