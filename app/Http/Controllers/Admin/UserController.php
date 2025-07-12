<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Tambahkan ini

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('shop')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menghapus user dari database.
     */
    public function destroy(User $user)
    {
        // PENGAMAN: Cek apakah user yang akan dihapus adalah admin yang sedang login.
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        // Hapus user. Semua data terkait (toko, produk, pesanan) akan terhapus karena cascade.
        $user->delete();

        return back()->with('success', 'User dan semua data terkait berhasil dihapus.');
    }
}