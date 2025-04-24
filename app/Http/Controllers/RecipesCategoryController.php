<?php

namespace App\Http\Controllers;

use App\Models\RecipeCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

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
        return view('livewire.pages.admin.category_recipes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:recipes_category,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        RecipeCategory::create([
            'name' => $request->name,
        ]);
        foreach ($request->file('image') as $image) {
            $path = $image->store('recipes_category', 'public');

            RecipeCategory::create([
                'image' => $path,
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Recipe category created successfully.',
            'redirect' => route('recipe.category.index'),
        ]);
    }

    public function edit($id)
    {
        $category = RecipeCategory::findOrFail($id);
        return view('livewire.pages.admin.category_recipes.edit', compact('id', 'category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:recipes_category,name,' . $id,
        ]);
        $category = RecipeCategory::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Recipe category updated successfully.',
            'redirect' => route('recipe.category.index'),
        ]);
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
