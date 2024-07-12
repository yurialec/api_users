<?php

namespace App\Services;

use App\Repositories\PermissionRepository;
use Illuminate\Support\Facades\Route;

class PermissionService
{
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAllPermissions()
    {
        return $this->permissionRepository->all();
    }

    public function getPermissionById($id)
    {
        return $this->permissionRepository->find($id);
    }

    public function createPermission($data)
    {
        /**
         * O usuario so pode cadastrar uma nova permissao caso a mesma ja seja um rota cadastrada
         */
        foreach (Route::getRoutes()->getRoutes() as $route) {
            $action = $route->getAction();
            if (array_key_exists('as', $action)) {
                $route_name[] = $action['as'];
            }
        }

        $removeItems = [
            "ignition.healthCheck",
            "ignition.executeSolution",
            "ignition.shareReport",
            "ignition.scripts",
            "ignition.styles"
        ];

        $route_name = array_diff($route_name, $removeItems);

        if (in_array($data['name'], $route_name)) {
            return $this->permissionRepository->create($data);
        } else {
            return false;
        }
    }

    public function updatePermission($id, $data)
    {
        foreach (Route::getRoutes()->getRoutes() as $route) {
            $action = $route->getAction();
            if (array_key_exists('as', $action)) {
                $route_name[] = $action['as'];
            }
        }

        $removeItems = [
            "ignition.healthCheck",
            "ignition.executeSolution",
            "ignition.shareReport",
            "ignition.scripts",
            "ignition.styles"
        ];

        $route_name = array_diff($route_name, $removeItems);

        if (in_array($data['name'], $route_name)) {
            return $this->permissionRepository->update($id, $data);
        } else {
            return false;
        }
    }

    public function deletePermission($id)
    {
        foreach (Route::getRoutes()->getRoutes() as $route) {
            $action = $route->getAction();
            if (array_key_exists('as', $action)) {
                $route_name[] = $action['as'];
            }
        }

        $removeItems = [
            "ignition.healthCheck",
            "ignition.executeSolution",
            "ignition.shareReport",
            "ignition.scripts",
            "ignition.styles"
        ];

        $route_name = array_diff($route_name, $removeItems);

        $permissionTodelete = $this->permissionRepository->find($id);

        if (in_array($permissionTodelete->name, $route_name)) {
            return false;
        } else {
            return $this->permissionRepository->delete($id);
        }
    }
}
