<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = UserResource::collection($this->userService->getAllUsers());

        if ($users) {
            return response()->json([
                'status' => true,
                'users' => $users,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Nenhum resultado encontrado',
            ], 400);
        }
    }

    public function store(CreateUserRequest $request)
    {
        $user = new UserResource($this->userService->createUser($request->all()));

        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'Usuário cadastrado com sucesso',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar usuário',
            ], 400);
        }
    }

    public function show($id)
    {
        $user = new UserResource($this->userService->getUserById($id));

        if ($user) {
            return response()->json([
                'status' => true,
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao encontrar usuário',
            ], 400);
        }
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        $user = new UserResource($this->userService->updateUser($id, $request->all()));

        if ($user) {
            return response()->json([
                'status' => true,
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar usuário',
            ], 400);
        }
    }

    public function delete($id)
    {
        $this->userService->deleteUser($id);

        return response()->json([
            'status' => true,
            'message' => 'Usuário excluido com sucesso',
        ]);
    }
}
