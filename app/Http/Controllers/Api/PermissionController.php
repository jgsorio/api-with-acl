<?php

namespace App\Http\Controllers\Api;

use App\Dto\Permissions\CreatePermissionDTO;
use App\Dto\Permissions\UpdatePermissionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    public function __construct(
        protected PermissionRepository $repository
    ) {}

    public function index(?string $filter = '')
    {
        $permissions = $this->repository->all($filter);
        return PermissionResource::collection($permissions);
    }

    public function store(CreatePermissionRequest $request)
    {
        $permission = $this->repository->create(new CreatePermissionDTO(...$request->validated()));
        return new PermissionResource($permission);
    }

    public function show(string $id)
    {
        if (!$permission = $this->repository->findById($id)) {
            return response()->json(['data' => []]);
        }

        return new PermissionResource($permission);
    }

    public function update(UpdatePermissionRequest $request, string $id)
    {
        if (!$permission = $this->repository->findById($id)) {
            return response()->json(['data' => []]);
        }

        $this->repository->update(
            new UpdatePermissionDTO(...$request->validated()),
            $permission
        );

        return new PermissionResource($permission);
    }

    public function destroy(string $id)
    {
        if (!$permission = $this->repository->findById($id)) {
            return response()->json(['data' => []]);
        }

        $this->repository->delete($permission->id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
