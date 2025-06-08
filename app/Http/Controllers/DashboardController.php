<?php

namespace App\Http\Controllers;

use App\Models\RecipeCategory;
use App\Models\Recipt;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        return view('livewire.pages.admin.dashboard.admin');
    }




    public function getstatus() {
        return [
            'total_recipes' => Recipt::count(),
            'accepted_recipes' => Recipt::where('status', 'accept')->count(),
            'category_recipes' => RecipeCategory::count(),
        ];
    }

}
