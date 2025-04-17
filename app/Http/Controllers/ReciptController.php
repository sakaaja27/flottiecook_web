<?php

namespace App\Http\Controllers;

use App\Models\Recipt;
use App\Models\ImageRecipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ReciptController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Recipt::with('images')->select('*');

            return DataTables::of($data)
                ->addIndexColumn()
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
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('recipt.edit', $row->id) . '" class="edit btn btn-primary btn-sm ml-1">Edit</a>';
                    $btn .= '<a href="javascript:void(0)" class="ml-1 delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
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
            'image_path' => 'required|array|max:3',
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
        $recipt = Recipt::with('images')->findOrFail($id);
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
            'description' => $request->description,
        ]);

        // untuk hitung gambar
        $existingImages = $recipt->images()->count();
        $newImages = $request->file('image_path') ?? [];

        if ($existingImages + count($newImages) > 3) {
            return response()->json([
                'success' => false,
                'message' => 'Total gambar tidak boleh lebih dari 3.'
            ], 422);
        }

        // Simpan gambar
        if ($request->hasFile('image_path')) {
            foreach ($newImages as $file) {
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

    public function destroy($id)
    {
        $recipt = Recipt::findOrFail($id);

        // Hapus semua gambar
        foreach ($recipt->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $recipt->delete();

        return response()->json([
            'success' => true,
            'message' => 'Recipe  deleted successfully',
            'redirect' => route('recipt.index'),
        ]);
    }

    public function destroyimage($id)
    {
        $image = ImageRecipt::findOrFail($id);

        // Hapus dari storage
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gambar berhasil dihapus.'
        ]);
    }
}
