<?php

namespace App\Repositories;

use App\Interfaces\RoleRepositoryInterface;
use App\Models\Roles;

class RoleRepository implements RoleRepositoryInterface
{
    protected  $role;
    protected  $permissionRole;

    public function __construct(Roles $role, PermissionRoleRepository $permissionRole)
    {
        $this->role = $role;
        $this->permissionRole = $permissionRole;
    }

    public function all()
    {
        return $this->role->all();
    }

    public function find($id)
    {
        return $this->role->find($id);
    }

    public function create(array $data)
    {
        return $this->role->create($data);
    }

    public function update($id, array $data)
    {
        $role = $this->role->find($id);
        $role->update($data);

        if (!empty($data['role_id'])) {
            $this->permissionRole->update($role->id, $data['role_id']);
        }

        return $role;
    }

    public function delete($id)
    {
        $role = $this->role->find($id);
        $role->delete();
    }
}
