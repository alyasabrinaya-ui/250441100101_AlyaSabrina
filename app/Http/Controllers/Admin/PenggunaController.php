<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class PenggunaController extends Controller
{
    public function index(): View
    {
        return view('admin.pengguna.index', [
            'daftar' => User::with('roles')->orderBy('id')->get(),
            'roles'  => Role::orderBy('id')->pluck('name'),
        ]);
    }

    public function create(): View
    {
        return view('admin.pengguna.form', [
            'user'  => new User,
            'roles' => Role::orderBy('id')->pluck('name'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email', 'unique:anggotas,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role'     => ['required', Rule::in(Role::pluck('name')->all())],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
        ]);

      
        $user->assignRole($request->user()->can('kelola role pengguna') ? $data['role'] : 'siswa');
        $user->buatAnggota();

        return redirect()->route('admin.pengguna.index')->with('sukses', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return view('admin.pengguna.form', ['user' => $user, 'roles' => collect()]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
                Rule::unique('anggotas', 'email')->ignore($user->anggota?->id),
            ],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $user->fill(['name' => $data['name'], 'email' => $data['email']]);
        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }
        $user->save();

        $user->buatAnggota()->update(['nama' => $user->name, 'email' => $user->email]);

        return redirect()->route('admin.pengguna.index')->with('sukses', 'Data pengguna berhasil diperbarui.');
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(Role::pluck('name')->all())],
        ]);

        $user->syncRoles($data['role']);

        return back()->with('sukses', 'Role pengguna berhasil diubah.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return back()->with('sukses', 'Pengguna berhasil dihapus.');
    }
}