<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role');
        $search = $request->get('search');

        $users = User::when($role, function ($q) use ($role) {
                return $q->where('role', $role);
            })
            ->when($search, function ($q) use ($search) {
                return $q->where(function ($sub) use ($search) {
                    $sub->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('identitas', 'like', "%{$search}%");
                });
            })
            ->orderBy('id_user', 'asc')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function toggleBanned($id)
    {
        $user = User::findOrFail($id);

        // Mencegah Admin memblokir akunnya sendiri saat login
        if ($user->id_user === Auth::user()->id_user) {
            return back()->with('error', 'Gagal! Anda tidak dapat memblokir akun Anda sendiri.');
        }

        $user->is_banned = !$user->is_banned;
        $user->save();

        $pesan = $user->is_banned 
            ? "Akun {$user->nama_lengkap} berhasil diblokir." 
            : "Akses akun {$user->nama_lengkap} berhasil dibuka kembali.";

        return back()->with('success', $pesan);
    }
}
