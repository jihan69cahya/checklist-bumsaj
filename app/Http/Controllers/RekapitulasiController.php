<?php

namespace App\Http\Controllers;

use App\Models\ChecklistCategory;
use App\Models\ChecklistSubcategory;
use App\Models\ChecklistEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RekapitulasiController extends Controller
{

    public function showRekapitulasi(Request $request)
    {
        // Get the category ID from the request, default to 1 if not provided
        $categoryId = $request->get('category_id', 1);

        // Find the category by ID
        $category = ChecklistCategory::find($categoryId);

        // Get the start and end dates from the request, default to today if not provided
        $startDate = $request->get('start_date', today()->format('Y-m-d'));
        $endDate = $request->get('end_date', today()->format('Y-m-d'));

        // Get subcategories for the selected category
        $subcategories = $category->subcategories;

        // Get entry values for the selected category (if applicable)
        $entry_values = $category->entry_values;

        // Fetch entries for the selected subcategories within the date range
        $entries = ChecklistEntry::whereIn('checklist_item_id', $subcategories->pluck('id'))
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->select('checklist_item_id', 'entry_value_id', DB::raw('count(*) as total'))
            ->groupBy('checklist_item_id', 'entry_value_id')
            ->get()
            ->groupBy('checklist_item_id')
            ->map(fn($items) => $items->pluck('total', 'entry_value_id')->toArray());

        // Pass data to the view
        return view('rekapitulasi', compact('subcategories', 'entries', 'categoryId', 'entry_values'));
    }
}
