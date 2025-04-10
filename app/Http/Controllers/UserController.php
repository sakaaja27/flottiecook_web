<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*')->orderByDesc('created_at')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="reset btn btn-info btn-sm" data-id="' . $row->id . '">Reset password</a>';
                    $btn .= '<a href="' . route('user.edit', $row->id) . '" class="edit btn btn-primary btn-sm ml-1">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('livewire.pages.admin.users.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt('password'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan!',
            'redirect' => route('users.index')
        ]);
    }

    public function create()
    {
        return view('livewire.pages.admin.users.create');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('livewire.pages.admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());
        // $user->update($request->only('name', 'email'));

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diperbaharui!',
            'redirect' => route('users.index')
        ]);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }

    public function reset($id)
    {
        $user = User::findOrFail($id);
        $user->update(['password' => bcrypt('password')]);

        return response()->json(['success' => 'User Reset successfully.']);
    }
}
