<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna untuk Super Admin.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        if ($request->filled('q')) {
            $search = trim($request->get('q'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->get('role'));
        }

        $perPageInput = $request->input('per_page', '15');
        if ($perPageInput === 'all' || $perPageInput === 'semua') {
            $perPage = 999999;
        } else {
            $perPage = (int) $perPageInput;
            if (!in_array($perPage, [15, 25, 50, 100, 150, 200], true)) {
                $perPage = 15;
            }
        }

        $users = $query->orderBy('id', 'desc')->paginate($perPage)->withQueryString();

        // Statistik
        $totalSuperAdmin = User::where('role', User::ROLE_SUPER_ADMIN)->count();
        $totalAdmin = User::where('role', User::ROLE_ADMIN)->count();
        $totalUser = User::where('role', User::ROLE_USER)->count();
        $totalAll = User::count();

        return view('users.index', compact(
            'users',
            'totalSuperAdmin',
            'totalAdmin',
            'totalUser',
            'totalAll'
        ));
    }

    /**
     * Menyimpan pengguna baru yang didaftarkan oleh Super Admin.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:super_admin,admin,user'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar pada akun lain.',
            'role.required' => 'Role pengguna wajib dipilih.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        ]);

        return back()->with('success', "Akun pengguna baru {$user->name} ({$user->email}) dengan role " . strtoupper($user->role) . " berhasil dibuat!");
    }

    /**
     * Memperbarui role pengguna.
     */
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', 'in:super_admin,admin,user'],
        ]);

        // Pencegahan: Super admin tidak boleh menurunkan role dirinya sendiri jika dia adalah satu-satunya super admin
        if ($user->id === auth()->id() && $validated['role'] !== User::ROLE_SUPER_ADMIN) {
            $superAdminCount = User::where('role', User::ROLE_SUPER_ADMIN)->count();
            if ($superAdminCount <= 1) {
                return back()->with('error', 'Gagal: Anda adalah satu-satunya Super Admin di sistem!');
            }
        }

        $user->update(['role' => $validated['role']]);

        return back()->with('success', "Role untuk pengguna {$user->name} berhasil diubah menjadi " . strtoupper($validated['role']) . "!");
    }

    /**
     * Reset password pengguna ke default (IRGTE165). Khusus Super Admin.
     */
    public function resetPassword(User $user)
    {
        $defaultPassword = 'IRGTE165';

        $user->forceFill([
            'password' => \Illuminate\Support\Facades\Hash::make($defaultPassword),
        ])->save();

        return back()->with('password_reset_success', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $defaultPassword,
        ]);
    }

    /**
     * Ubah custom password pengguna lain secara langsung. Khusus Super Admin.
     */
    public function updatePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'new_password' => ['required', 'string', 'min:8'],
        ], [
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal harus 8 karakter.',
        ]);

        $user->forceFill([
            'password' => \Illuminate\Support\Facades\Hash::make($validated['new_password']),
        ])->save();

        return back()->with('password_reset_success', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $validated['new_password'],
        ]);
    }

    /**
     * Menghapus akun pengguna.
     */
    public function destroy(User $user)
    {
        // Pencegahan: Tidak boleh menghapus akun sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Gagal: Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "Akun pengguna {$name} berhasil dihapus!");
    }
}
