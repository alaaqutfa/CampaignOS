<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;
        if (Auth::user()->is_super_admin) {
            $users = User::with('company')->get();
        } else {
            $users = User::where('company_id', $company->id)->paginate(20);
        }
        return view('users.index', compact('users', 'company'));
    }

    public function create()
    {
        $company = Auth::user()->company;
        $roles = $this->getAvailableRoles();
        return view('users.create', compact('company', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
        ]);

        $company = Auth::user()->company;
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'company_id' => Auth::user()->is_super_admin ? null : $company->id,
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $company = Auth::user()->company;
        $roles = $this->getAvailableRoles();
        return view('users.edit', compact('user', 'company', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|string|exists:roles,name',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    private function getAvailableRoles()
    {
        $currentUser = Auth::user();
        if ($currentUser->is_super_admin) {
            return Role::all()->pluck('name');
        }
        // الأدوار المسموحة لمدير الشركة
        $allowed = ['company_admin', 'designer', 'contractor', 'accountant', 'manager', 'measurer', 'installer'];
        return Role::whereIn('name', $allowed)->get()->pluck('name');
    }
}
