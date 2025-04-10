<?php

namespace App\Http\Controllers;

use App\Models\Recipt;
use App\Models\ImageRecipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReciptController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Recipt::select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <a href="javascript:void(0)" class="edit btn btn-warning btn-sm" data-id="' . $row->id . '">Edit</a>
                        <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('livewire.pages.admin.recipt.index');
    }

    public function create()
    {
        return view('livewire.pages.admin.recipt.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image_path' => 'required|array',
            'image_path.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $recipt = Recipt::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id()
        ]);

        foreach ($request->file('image_path') as $image) {
            $path = $image->store('recipes', 'public');

            ImageRecipt::create([
                'recipt_id' => $recipt->id,
                'image_path' => $path,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Resep berhasil ditambahkan!',
            'redirect' => route('recipt.index'),
        ]);
    }

    public function destroy(string $id)
    {
        Recipt::findOrFail($id)->delete();
        return response()->json(['success' => 'Resep berhasil dihapus.']);
    }
}
