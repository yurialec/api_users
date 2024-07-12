<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissonRequest;
use App\Http\Resources\PermissionResource;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = PermissionResource::collection($this->permissionService->getAllPermissions());

        if ($permissions) {
            return response()->json([
                'status' => true,
                'permissions' => $permissions,
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
    public function store(CreatePermissionRequest $request)
    {
        $permission = $this->permissionService->createPermission($request->all());

        if ($permission) {
            return response()->json([
                'status' => true,
                'message' => 'Permissão cadastrada com sucesso',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar permissão',
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
        $permission = new PermissionResource($this->permissionService->getPermissionById($id));

        if ($permission) {
            return response()->json([
                'status' => true,
                'permission' => $permission,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao encontrar Permissao',
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
    public function update(UpdatePermissonRequest $request, $id)
    {
        $permission = $this->permissionService->updatePermission($id, $request->all());

        if ($permission) {
            $permissionResource = new PermissionResource($this->permissionService->getPermissionById($id));
            return response()->json([
                'status' => true,
                'permission' => $permissionResource,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao encontrar permissão',
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
        $permissionToDelete =  $this->permissionService->deletePermission($id);

        if (!$permissionToDelete) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao excluir permissão',
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Permissão excluida com sucesso',
            ]);
        }
    }
}
