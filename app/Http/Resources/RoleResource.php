<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'permissions' => $this->permissions->map(function ($permission) {
                return $permission->name;
            }),
        ];
    }
}
