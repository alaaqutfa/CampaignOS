<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\StoreUserRequest;
use App\Http\Requests\SuperAdmin\UpdateUserRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('is_super_admin', false)->latest()->paginate(20);
        return view('super-admin.users.index', compact('users'));
    }

    public function create()
    {
        $companies = Company::where('status', true)->get();
        $roles     = Role::all();
        return view('super-admin.users.create', compact('companies', 'roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'company_id' => $request->company_id,
        ]);

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $companies = Company::where('status', true)->get();
        $roles     = Role::all();
        return view('super-admin.users.edit', compact('user', 'companies', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'company_id' => $request->company_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
