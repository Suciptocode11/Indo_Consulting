<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Tampilkan daftar seluruh pengguna back office.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($level = $request->input('level')) {
            $query->where('level', $level);
        }

        $users = $query->orderByRaw("FIELD(level, 'super_admin', 'admin', 'finance')")
                       ->orderBy('nama')
                       ->paginate(15)
                       ->withQueryString();

        $roleLabels = [
            'super_admin' => 'Super Admin',
            'admin'       => 'Admin',
            'finance'     => 'Finance',
        ];

        return view('admin.users.index', compact('users', 'roleLabels'));
    }

    /**
     * Simpan akun pengguna baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|max:100|alpha_dash|unique:users,username',
            'email'    => 'required|email|max:255|unique:users,email',
            'level'    => 'required|in:super_admin,admin,finance',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'username.unique'    => 'Username sudah digunakan oleh akun lain.',
            'username.alpha_dash'=> 'Username hanya boleh berisi huruf, angka, tanda strip, dan garis bawah.',
            'email.unique'       => 'Alamat email sudah terdaftar.',
            'password.min'       => 'Password minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'nama'     => $validated['nama'],
            'username' => strtolower($validated['username']),
            'email'    => strtolower($validated['email']),
            'level'    => $validated['level'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Akun '{$validated['username']}' berhasil dibuat.");
    }

    /**
     * Tampilkan form edit akun pengguna.
     */
    public function edit(User $user)
    {
        $roleLabels = [
            'super_admin' => 'Super Admin',
            'admin'       => 'Admin',
            'finance'     => 'Finance',
        ];

        return view('admin.users.edit', compact('user', 'roleLabels'));
    }

    /**
     * Perbarui data akun pengguna & password.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => ['required', 'string', 'max:100', 'alpha_dash', Rule::unique('users')->ignore($user->id)],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'level'    => 'required|in:super_admin,admin,finance',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'username.unique'    => 'Username sudah digunakan oleh akun lain.',
            'email.unique'       => 'Alamat email sudah terdaftar.',
            'password.min'       => 'Password minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        // Cegah Super Admin menurunkan hak akses akun sendiri
        if ($user->id === Auth::id() && $validated['level'] !== 'super_admin') {
            return back()->withInput()->with('error', 'Anda tidak dapat menurunkan hak akses akun Anda sendiri.');
        }

        $user->nama     = $validated['nama'];
        $user->username = strtolower($validated['username']);
        $user->email    = strtolower($validated['email']);
        $user->level    = $validated['level'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', "Data akun '{$user->username}' berhasil diperbarui.");
    }

    /**
     * Hapus akun pengguna.
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan.');
        }

        if (User::count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus satu-satunya akun di sistem.');
        }

        $username = $user->username;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Akun '{$username}' berhasil dihapus.");
    }
}

