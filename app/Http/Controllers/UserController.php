<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 10;

        $query = User::query();

        if (strlen($katakunci)) {
            $query->where('id', 'like', "%$katakunci%")
                ->orWhere('name', 'like', "%$katakunci%")
                ->orWhere('email', 'like', "%$katakunci%");
        }

        $users = $query->orderBy('id', 'desc')->paginate($jumlahbaris);

        return view('livewire.pages.admin.users.index', compact('users'));
    }
}
