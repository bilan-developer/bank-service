<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User\User;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @param UserService $service
     */
    public function __construct(protected UserService $service)
    {
    }

    /**
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $users = $this->service->list($attributes);
        return UserResource::collection($users)->response();
    }

    /**
     * @param UpdateRequest $request
     * @param User $user
     *
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, User $user): JsonResponse
    {
        $attributes = $request->validated();
        $user = $this->service->update($attributes, $user);

        return (new UserResource($user))->response();
    }
}
