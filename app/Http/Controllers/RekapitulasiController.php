<?php

namespace App\Http\Controllers;

use App\Models\ChecklistEntry;
use App\Models\ChecklistSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapitulasiController extends Controller
{
    public function showRekapitulasi(Request $request)
    {
        $categoryId = $request->get('category_id', 1);

        $subcategories = ChecklistSubcategory::where('category_id', $categoryId)->get();

        $entries = ChecklistEntry::whereIn('subcategory_id', $subcategories->pluck('id'))
            ->select('subcategory_id', 'entry_value_id', DB::raw('count(*) as total'))
            ->groupBy('subcategory_id', 'entry_value_id')
            ->get()
            ->groupBy('subcategory_id')
            ->map(function ($items)
            {
                return $items->pluck('total', 'entry_value_id')->toArray();
            });

        return view('rekapitulasi', compact('subcategories', 'entries'));
    }
}
