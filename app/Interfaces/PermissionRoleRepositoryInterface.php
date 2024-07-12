<?php

namespace App\Interfaces;

interface PermissionRoleRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(int $permissionId, array $data);
    public function update($id, array $data);
    public function delete($id);
}
