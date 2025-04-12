<?php
// app/Http/Controllers/ReciptController.php

namespace App\Http\Controllers;

use App\Models\Recipt;
use App\Models\ImageRecipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use public\storage\recipes;
use public\Storage;


class ReciptController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Recipt::with('images')->select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn('photo', function ($row) {
                //     if ($row->images->count() > 0) {
                //         $url = asset('storage/' . $row->images->first()->image_path);
                //         return '<img src="' . $url . '" style="width: 100px; height: auto; border-radius: 0;">';
                //     }
                //     return 'No Image';
                // })

                ->addColumn('status', function ($row) {
                    $statuses = ['pending', 'approved', 'rejected'];

                    $colorClasses = [
                        'pending' => 'bg-warning text-dark',
                        'approved' => 'bg-success text-white',
                        'rejected' => 'bg-danger text-white',
                    ];

                    $dropdown = '<select class="form-select form-select-sm status-dropdown ' . ($colorClasses[$row->status] ?? '') . '" data-id="' . $row->id . '">';

                    foreach ($statuses as $status) {
                        $selected = $row->status === $status ? 'selected' : '';
                        $dropdown .= '<option value="' . $status . '" ' . $selected . '>' . ucfirst($status) . '</option>';
                    }

                    $dropdown .= '</select>';
                    return $dropdown;
                })

                // ->addColumn('action', function ($row) {
                //     return '
                //         <a href="' . route('recipt.edit', $row->id) . '" class="edit btn btn-warning btn-sm" data-id="' . $row->id . '">Edit</a>
                //         <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
                // })

                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('recipt.edit', $row->id) . '" class="edit btn btn-primary btn-sm ml-1">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
                    return $btn;
                })

                ->rawColumns(['photo', 'status', 'action'])
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
            'status' => 'string',
            'image_path' => 'required|array',
            'image_path.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $recipt = Recipt::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'pending',
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

    public function edit($id)
{
    $recipt = Recipt::findOrFail($id);
    return view('livewire.pages.admin.recipt.edit', compact('recipt'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'image_path.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $recipt = Recipt::findOrFail($id);
    $recipt->update([
        'name' => $request->name,
        'description' => $request->description
    ]);

    // Simpan gambar baru jika ada
    if ($request->hasFile('image_path')) {
        foreach ($request->file('image_path') as $file) {
            $path = $file->store('recipes', 'public');

            ImageRecipt::create([
                'recipt_id' => $recipt->id,
                'image_path' => $path
            ]);
        }
    }

    return response()->json([
        'success' => true,
        'message' => 'Recipe updated successfully!',
        'redirect' => route('recipt.index')
    ]);
}


    public function destroy(string $id)
    {
        Recipt::findOrFail($id)->delete();
        return response()->json(['success' => 'Resep berhasil dihapus.']);
    }
    public function destroyimage($id)
{
    $image = ImageRecipt::findOrFail($id);

    // Hapus file dari storage
    Storage::disk('public')->delete($image->image_path);

    // Hapus dari database
    $image->delete();

    return back()->with('success', 'Gambar berhasil dihapus.');
}
}
