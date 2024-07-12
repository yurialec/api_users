<?php

namespace App\Repositories;

use App\Interfaces\PermissionRepositoryInterface;
use App\Models\Permissions;

class PermissionRepository implements PermissionRepositoryInterface
{
    protected  $permission;

    public function __construct(Permissions $permission)
    {
        $this->permission = $permission;
    }

    public function all()
    {
        return $this->permission->get();
    }

    public function find($id)
    {
        return $this->permission->find($id);
    }

    public function create(array $data)
    {
        return $this->permission->create($data);
    }

    public function update($id, array $data)
    {
        $permission = $this->permission->find($id);
        $permission->update($data);
        return $permission;
    }

    public function delete($id)
    {
        $permission = $this->permission->find($id);
        $permission->delete();
        return true;
    }
}
