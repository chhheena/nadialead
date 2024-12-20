<?php

namespace App\Http\Controllers;

use App\Models\Enums\PermissionableModel;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::select('id', 'name')->get();
        $permissions = Permission::select('id', 'name')->get();
        $models = array_map(fn($enum) => $enum->name, PermissionableModel::cases());

        return Inertia::render('User/AssignPermission', compact('permissions','roles', 'models'));
    }
}
