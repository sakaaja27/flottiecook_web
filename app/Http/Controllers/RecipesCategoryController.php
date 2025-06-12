<?php

namespace App\Http\Controllers;

use App\Models\RecipeCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class RecipesCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RecipeCategory::select(['id', 'name'])->orderByDesc('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('recipe.category.edit', $row->id);

                    $btn = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a> ';
                    $btn .= '<button type="button" class="delete_category btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">Delete</button>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('livewire.pages.admin.category_recipes.index');
    }


    public function create()
    {
        // return view('livewire.pages.admin.category_recipes.create', compact('categories'));
        return view('livewire.pages.admin.category_recipes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:recipes_category,name',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $recipeCategory = RecipeCategory::create([
            'name' => $request->name,
        ]);
        $image = $request->file('image');
        if ($image) {
            $path = $image->store('recipeCategory', 'public');
            $recipeCategory->update([
                'image' => $path,
            ]);
        }
        return redirect()->route('recipe.category.index')
            ->with('success', 'Success add category recipes.');
    }

    public function edit($id)
    {
        $category = RecipeCategory::findOrFail($id);
        return view('livewire.pages.admin.category_recipes.edit', compact('id', 'category'));
    }


    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255|unique:recipes_category,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = RecipeCategory::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);
        if ($request->has('delete_image') && $request->delete_image == 1) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $category->update(['image' => null]);
        }

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $path = $request->file('image')->store('recipeCategory', 'public');

            $category->update([
                'image' => $path,
            ]);
        }

        return redirect()
            ->route('recipe.category.index')
            ->with('success', 'Kategori resep berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = RecipeCategory::findOrFail($id);
        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Recipe category deleted successfully.',
            'redirect' => route('recipe.category.index'),
        ]);
    }
}
