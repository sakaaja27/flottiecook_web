<?php

namespace App\Http\Controllers;

use App\Models\Recipt;
use App\Models\ImageRecipt;
use App\Models\RecipeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ReciptController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Recipt::with('images')->orderBy('created_at', 'desc');
            if ($request->status && $request->status != 'all') {
                $data->where('status', $request->status);
            }

            if (Auth::user()->role == 'admin') {
                $data = $data;
            } elseif (Auth::user()->role == 'user') {
                $data = $data->where('user_id', Auth::id());
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $colorClasses = [
                        'pending' => 'bg-warning text-dark',
                        'accept' => 'bg-success text-white',
                        'reject' => 'bg-danger text-white',
                    ];
                    $statusClass = $colorClasses[$row->status] ?? 'bg-secondary text-white';
                    return '<span class="badge ' . $statusClass . '">' . ucfirst($row->status) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('recipt.show', $row->id) . '" class="show btn text-white btn-info btn-sm ml-1">Show</a>';
                    if ($row->status == 'pending' && Auth::user()->role == 'user') {
                        $btn .= '<a href="' . route('recipt.edit', $row->id) . '" class="edit btn btn-primary btn-sm ml-1">Edit</a>';
                    }
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

        $categories = RecipeCategory::all();
        return view('livewire.pages.admin.recipt.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'status' => 'string',
            'ingredient' => 'string',
            'tools' => 'string',
            'instruction' => 'string',
            'image_path' => 'required|array|max:3',
            'image_path.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        //menyimpan data ke table recipt
        $recipt = Recipt::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'ingredient' => $request->ingredient,
            'tools' => $request->tools,
            'instruction' => $request->instruction,
            'category_id' => $request->category_id,
            'status' => 'pending',
            'user_id' => Auth::id()
        ]);

        try {
            $data = $recipt;
            $data['user_id'] = Auth::id();
            foreach ($request->file('image_path') as $image) {
                $path = $image->store('recipes/' . now()->format('Y-m.d') . '/' . $data['user_id'], 'public');

                ImageRecipt::create([
                    'recipt_id' => $recipt->id,
                    'image_path' => $path,
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save recipe. Please try again.',
            ], 500);
        }


        return response()->json([
            'success' => true,
            'message' => 'Recipe has been successfully saved!',
            'redirect' => route('recipt.index'),
        ]);
    }

    public function edit($id)
    {
        $recipt = Recipt::with('images')->findOrFail($id);
        $categories = RecipeCategory::all();
        return view('livewire.pages.admin.recipt.edit', compact('recipt', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string',
            'tools' => 'string',
            'ingredient' => 'string',
            'instruction' => 'string',
            'image_path.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $recipt = Recipt::findOrFail($id);

        $recipt->update([
            'name' => $request->name,
            'description' => $request->description,
            'tools' => $request->tools,
            'ingredient' => $request->ingredient,
            'instruction' => $request->instruction,
            'category_id' => $request->category_id
        ]);

        // untuk hitung gambar
        $existingImages = $recipt->images()->count();
        $newImages = $request->file('image_path') ?? [];

        if ($existingImages + count($newImages) > 3) {
            return response()->json([
                'success' => false,
                'message' => 'Maximum of 3 images allowed.'
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
            'message' => 'Image deleted successfully.'
        ]);
    }

    public function show($id)
    {
        $recipt = Recipt::with('images')->findOrFail($id);
        $categories = RecipeCategory::all();
        return view('livewire.pages.admin.recipt.detail', compact('recipt', 'categories'));
    }

    public function approvedRejected(Request $request, $id)
    {
        $recipt = Recipt::findOrFail($id);
        $status = $request->input('status');

        if (!in_array($status, ['accept', 'reject'])) {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid'
            ], 400);
        }

        $recipt->status = $status;
        $recipt->save();

        return response()->json([
            'success' => true,
            'message' => "Recipe has been $status.",
            'redirect' => route('recipt.index')
        ]);
    }
}
