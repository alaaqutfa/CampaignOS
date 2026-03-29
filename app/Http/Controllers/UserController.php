<?php
namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

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
        $roles   = $this->getAvailableRoles();
        return view('users.create', compact('company', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles'    => 'required|array', // الآن مصفوفة
            'roles.*'  => 'string|exists:roles,name',
        ]);

        // التحقق من صحة مجموعة الأدوار
        $this->validateRoleCombination($validated['roles']);

        $company = Auth::user()->company;
        $user    = User::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'company_id' => Auth::user()->is_super_admin ? null : $company->id,
        ]);

        $user->syncRoles($validated['roles']); // استخدام syncRoles للمصفوفة

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $company   = Auth::user()->company;
        $roles     = $this->getAvailableRoles();
        $userRoles = $user->roles->pluck('name')->toArray();
        return view('users.edit', compact('user', 'company', 'roles', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'roles'   => 'required|array',
            'roles.*' => 'string|exists:roles,name',
        ]);

        $this->validateRoleCombination($validated['roles']);

        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);

        $user->syncRoles($validated['roles']);

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
            $roles = Role::all()->pluck('name');
        } else {
            $allowed = ['company_admin', 'designer', 'accountant', 'manager', 'measurer', 'installer'];
            $roles   = Role::whereIn('name', $allowed)->get()->pluck('name');
        }

        return $roles->map(function ($role) {
            $group = 'other';
            if (in_array($role, ['measurer', 'installer'])) {
                $group = 'field';
            }

            if (in_array($role, ['company_admin', 'manager', 'accountant'])) {
                $group = 'management';
            }

            if ($role === 'designer') {
                $group = 'design';
            }

            return ['name' => $role, 'group' => $group];
        });
    }

    private function validateRoleCombination(array $roles)
    {
        // التحقق من عدم وجود أكثر من دور واحد من إدارة/تصميم
        $managementRoles = ['company_admin', 'manager', 'accountant'];
        $designRoles     = ['designer'];
        $fieldRoles      = ['measurer', 'installer'];

        $selectedManagement = array_intersect($roles, $managementRoles);
        $selectedDesign     = array_intersect($roles, $designRoles);
        $selectedField      = array_intersect($roles, $fieldRoles);

        if (count($selectedManagement) > 1) {
            throw ValidationException::withMessages(['roles' => 'You cannot select more than one management role.']);
        }
        if (count($selectedDesign) > 1) {
            throw ValidationException::withMessages(['roles' => 'You cannot select more than one design role.']);
        }
        if (count($selectedManagement) + count($selectedDesign) > 1) {
            throw ValidationException::withMessages(['roles' => 'You cannot combine management and design roles.']);
        }
        // السماح باختيار measurer و installer معاً أو أحدهما، ولا يمكن دمجهما مع إدارة/تصميم
        if (! empty($selectedField) && (! empty($selectedManagement) || ! empty($selectedDesign))) {
            throw ValidationException::withMessages(['roles' => 'Field roles cannot be combined with management or design roles.']);
        }
    }
}
