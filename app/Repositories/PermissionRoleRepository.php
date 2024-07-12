<?php

namespace App\Repositories;

use App\Interfaces\PermissionRoleRepositoryInterface;
use App\Models\PermissionRole;

class PermissionRoleRepository implements PermissionRoleRepositoryInterface
{
    protected  $permissionRole;

    public function __construct(PermissionRole $permissionRole)
    {
        $this->permissionRole = $permissionRole;
    }

    public function all()
    {
        return $this->permissionRole->all();
    }

    public function find($id)
    {
        return $this->permissionRole->find($id);
    }

    public function create(int $permissionId, array $data)
    {
        return $this->permissionRole->create($data);
    }

    public function update($id, array $data)
    {
        $acquiredPermissions = $this->permissionRole->where('role_id', $id)->pluck('permission_id')->toArray();

        $permissionToDelete = array_diff($acquiredPermissions, $data);

        if (!empty($permissionToDelete)) {
            $this->permissionRole->where('role_id', $id)->whereNotIn('permission_id', $data)->delete();
        }

        $newPermission = array_diff($data, $acquiredPermissions);

        foreach ($newPermission as $permission) {
            $this->permissionRole->create([
                'permission_id' => $permission,
                'role_id' => $id,
            ]);
        }

        return true;
    }

    public function delete($id)
    {
        $permissionRole = $this->permissionRole->find($id);
        $permissionRole->delete();
    }
}
