<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    /**
     * Display a listing of roles.
     */
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('super-admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('super-admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|unique:roles,name',
            'permissions'   => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('super-admin.roles.index')
            ->with('success', "Role '{$role->name}' created successfully.");
    }

    /**
     * Show the form for editing a role.
     */
    public function edit(Role $role)
    {
        $permissions     = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('super-admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, Role $role)
    {
        // Prevent renaming critical roles
        if (in_array($role->name, ['super_admin', 'platform_admin']) && $request->name !== $role->name) {
            return redirect()->back()->withErrors(['name' => 'Cannot rename system role.']);
        }

        $request->validate([
            'name'          => 'required|string|unique:roles,name,' . $role->id,
            'permissions'   => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('super-admin.roles.index')
            ->with('success', "Role '{$role->name}' updated successfully.");
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role)
    {
        if (in_array($role->name, ['super_admin', 'platform_admin'])) {
            return redirect()->route('super-admin.roles.index')
                ->with('error', 'Cannot delete system role.');
        }

        $role->delete();

        return redirect()->route('super-admin.roles.index')
            ->with('success', "Role '{$role->name}' deleted successfully.");
    }
}
