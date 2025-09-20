<?php

namespace App\Http\Controllers\Api;

use App\Dto\Users\CreateUserDTO;
use App\Dto\Users\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(protected UserRepository $repository) {}

    public function index(Request $request)
    {
        $user = $this->repository->all($request->filter ?? '');
        return UserResource::collection($user);
    }

    public function store(CreateUserRequest $request)
    {
        $user = $this->repository->create(
            new CreateUserDTO(...$request->validated())
        );
        return new UserResource($user);
    }

    public function show(string $id)
    {
        if (!$user = $this->repository->findById($id)) {
            return response()->json(['data' => []]);
        }
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        if (!$user = $this->repository->findById($id)) {
            return response()->json(['data' => []]);
        }

        $this->repository->update(new UpdateUserDTO(...$request->validated()), $user);
        return new UserResource($user);
    }

    public function destroy(string $id)
    {
        if (!$user = $this->repository->findById($id)) {
            return response()->json(['data' => []]);
        }

        $this->repository->delete($user->id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function syncPermissions(Request $request, string $id)
    {
        if (!$user = $this->repository->findById($id)) {
            return response()->json(['data' => []]);
        }

        $this->repository->syncPermissions($request->permissions, $user);
        return new UserResource($user);
    }

    public function getPermissions(string $id)
    {
        if (!$user = $this->repository->findById($id)) {
            return response()->json(['data' => []]);
        }

        $permissions = $this->repository->getPermissions($user);
        return PermissionResource::collection($permissions);
    }
}
