<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $table = 'roles';

    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->hasManyThrough(
            Permissions::class,
            PermissionRole::class,
            'role_id',
            'id',
            'id',
            'permission_id',
        );
    }
}
