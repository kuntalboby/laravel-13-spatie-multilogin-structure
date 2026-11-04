<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function edit(Role $role)
    {
        abort_if($role->name === 'admin', 404);

        $modules = Module::all();
        $granted = $role->permissions->pluck('name')->toArray();
        // return $granted;

        return view('admin.permissions.edit', compact('role', 'modules', 'granted'));
    }

    public function update(Request $request, Role $role)
    {
        abort_if($role->name === 'admin', 404);

        $request->validate([
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        $role->syncPermissions($request->input('permissions', []));

        return back()->with('success', 'Permissions updated.');
    }
}