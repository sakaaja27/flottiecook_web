<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class UserController extends Controller
{
    // show datatables
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query();

            return DataTablesDataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('livewire.pages.admin.users.index');
    }

    // Menyimpan data baru
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
    ]);

    User::create($request->all());

    return redirect()->route('user')->with('success', 'User berhasil disimpan!');
}





    public function create()
    {
        return view('livewire.pages.admin.users.create');

    }

    // Mengambil data untuk edit
    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        User::find($id)->update($request->all());

        return response()->json(['success' => 'User updated successfully.']);
    }

    // Hapus data
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }
}
