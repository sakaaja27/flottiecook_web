<?php

namespace App\Http\Controllers;

use App\Models\RecipeCategory;
use App\Models\Recipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('livewire.pages.admin.dashboard.admin');
    }

    public function getstatus()
    {
        return [
            'total_recipes' => Recipt::count(),
            'accepted_recipes' => Recipt::where('status', 'accept')->count(),
            'category_recipes' => RecipeCategory::count(),
        ];
    }

    public function getChartData($type)
    {
        $query = Recipt::query();

        if ($type === 'day') {
            $query->selectRaw('DATE(created_at) as date, COUNT(*) as value')
                ->whereDate('created_at', '>=', now()->subDays(7))
                ->groupBy('date');
        } elseif ($type === 'week') {
            $query->selectRaw('YEARWEEK(created_at, 1) as week, MIN(DATE(created_at)) as date, COUNT(*) as value')
                ->whereDate('created_at', '>=', now()->subWeeks(4))
                ->groupBy('week');
        } elseif ($type === 'month') {
            $query->selectRaw('DATE_FORMAT(created_at, "%Y-%m-01") as date, COUNT(*) as value')
                ->whereDate('created_at', '>=', now()->subMonths(12))
                ->groupBy('date');
        }

        $data = $query->orderBy('date')->get();

        return response()->json($data);
    }
}
