<?php

namespace App\Http\Controllers;

use App\Models\Recipt;
use App\Models\RecipeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Models\ImageRecipt;


class HistoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Recipt::where('user_id', Auth::id());

            if ($request->has('status') && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editButton = '';
                    $showButton = '<a href="' . route('history.show', $row->id) . '" class="btn btn-sm btn-info ml-1">Show</a>';
                    $deleteButton = '<button type="button" class="btn btn-sm btn-danger ml-1 delete" data-id="' . $row->id . '">Delete</button>';

                    if ($row->status === 'pending') {
                        $editButton = '<a href="' . route('history.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a> ';
                    }

                    return $editButton . $showButton . $deleteButton;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status === 'pending') {
                        return '<span class="badge bg-warning text-dark">Pending</span>';
                    } elseif ($row->status === 'accept') {
                        return '<span class="badge bg-success">Accepted</span>';
                    } elseif ($row->status === 'reject') {
                        return '<span class="badge bg-danger">Rejected</span>';
                    } else {
                        return '<span class="badge bg-secondary">Unknown</span>';
                    }
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        $recipes = Recipt::where('user_id', Auth::id())
            ->with(['images', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $categories = RecipeCategory::all();

        return view('livewire.pages.frontend.history.index', compact('categories', 'recipes'));
    }

    public function show(string $id)
    {
        $recipe = Recipt::where('user_id', Auth::id())
            ->where('id', $id)
            ->with(['images', 'category'])
            ->firstOrFail();
        $categories = \App\Models\RecipeCategory::all();

        return view('livewire.pages.frontend.history.detail', compact('recipe', 'categories'));
    }

    public function edit(string $id)
    {
        $recipe = Recipt::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($recipe->status !== 'pending') {
            return redirect()->route('history.index')->with('error', 'Recipe already accepted and cannot be edited.');
        }
        $categories = \App\Models\RecipeCategory::all();

        return view('livewire.pages.frontend.history.edit', compact('recipe', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $recipe = Recipt::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($recipe->status !== 'pending') {
            return redirect()->route('history.index')->with('error', 'You cannot update an accepted recipe.');
        }

        $recipe->update([
            'name' => $request->name,
            'description' => $request->description,
            'ingredient' => $request->ingredient,
            'instruction' => $request->instruction,
            'category_id' => $request->category_id,

        ]);

         $existingImages = $recipe->images()->count();
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
                    'recipt_id' => $recipe->id,
                    'image_path' => $path
                ]);
            }
        }
return response()->json([
    'message' => 'Recipe updated successfully!',
    'redirect' => route('history.index')
]);    }

    public function destroy(string $id)
    {
        try {
            $recipe = Recipt::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $recipe->delete();

            return response()->json([
                'success' => true,
                'message' => 'Recipe deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete recipe.'
            ], 500);
        }
    }

    public function getStats()
    {
        $userId = Auth::id();

        return [
            'total' => Recipt::where('user_id', $userId)->count(),
            'pending' => Recipt::where('user_id', $userId)->where('status', 'pending')->count(),
            'accept' => Recipt::where('user_id', $userId)->where('status', 'accept')->count(),
            'rejected' => Recipt::where('user_id', $userId)->where('status', 'reject')->count(),
        ];
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
            'redirect' => route('history.index')
        ]);
    }
}
