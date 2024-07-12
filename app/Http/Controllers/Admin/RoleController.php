<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = RoleResource::collection($this->roleService->getAllRoles());

        if ($roles) {
            return response()->json([
                'status' => true,
                'roles' => $roles,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Nenhum resultado encontrado',
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoleRequest $request)
    {
        $roles = new RoleResource($this->roleService->createRole($request->all()));

        if ($roles) {
            return response()->json([
                'status' => true,
                'message' => 'Perfil cadastrado com sucesso',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar perfil',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = new RoleResource($this->roleService->getRoleById($id));

        if ($role) {
            return response()->json([
                'status' => true,
                'role' => $role,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao encontrar Perfil',
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $role = new RoleResource($this->roleService->updateRole($id, $request->all()));

        if ($role) {
            return response()->json([
                'status' => true,
                'role' => $role,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar perfil',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $this->roleService->deleteRole($id);

        return response()->json([
            'status' => true,
            'message' => 'Perfil excluido com sucesso',
        ]);
    }
}
