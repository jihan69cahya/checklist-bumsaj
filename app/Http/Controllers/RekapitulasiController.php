<?php

namespace App\Http\Controllers;

use App\Models\ChecklistSubcategory;
use App\Models\ChecklistEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RekapitulasiController extends Controller
{

    public function showRekapitulasi(Request $request)
    {
        $categoryId = $request->get('category_id', 1);
        $startDate = $request->get('start_date', today()->format('Y-m-d'));
        $endDate = $request->get('end_date', today()->format('Y-m-d'));
    
        $subcategories = ChecklistSubcategory::where('category_id', $categoryId)->get();
    
        $entries = ChecklistEntry::whereIn('item_id', $subcategories->pluck('id'))
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->select('item_id', 'entry_value_id', DB::raw('count(*) as total'))
            ->groupBy('item_id', 'entry_value_id')
            ->get()
            ->groupBy('item_id')
            ->map(fn($items) => $items->pluck('total', 'entry_value_id')->toArray());
    
        return view('rekapitulasi', compact('subcategories', 'entries', 'categoryId'));
    }
    

}
