<?php

namespace App\Http\Controllers;

use App\Models\ChecklistCategory;
use App\Models\ChecklistEntry;
use App\Models\ChecklistItem;
use App\Models\ChecklistSubcategory;
use App\Models\Period;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    public function show()
    {
        $today = Carbon::today();

        $currentPeriod = Period::where('start_time', '<=', now('Asia/Jakarta')->format('H:i:s'))
            ->where('end_time', '>', now('Asia/Jakarta')->format('H:i:s'))
            ->first();


        $periods = Period::all();

        $itemsCountByCategory = ChecklistCategory::leftJoin('checklist_items', 'checklist_items.checklist_category_id', '=', 'checklist_categories.id')
            ->select(['checklist_categories.id', 'checklist_categories.name', DB::raw('COUNT(checklist_items.id) as checklist_items_count')])
            ->groupBy(['checklist_categories.id', 'checklist_categories.name'])
            ->get();
        $entriesCountByCategory = ChecklistCategory::leftJoin('checklist_items', 'checklist_items.checklist_category_id', '=', 'checklist_categories.id')
            ->leftJoin('checklist_entries', function ($join) use ($currentPeriod, $today)
            {
                $join->on('checklist_entries.checklist_item_id', '=', 'checklist_items.id')
                    ->where('checklist_entries.period_id', '=', $currentPeriod->id ?? 0)
                    ->whereDate('checklist_entries.created_at', '=', $today);
            })
            ->select(['checklist_categories.id', 'checklist_categories.name', DB::raw('COUNT(checklist_entries.id) as checklist_entries_count')])
            ->groupBy(['checklist_categories.id', 'checklist_categories.name'])
            ->get();

        $entriesCountByCategoryToday = ChecklistCategory::leftJoin('checklist_items', 'checklist_items.checklist_category_id', '=', 'checklist_categories.id')
            ->leftJoin('checklist_entries', function ($join) use ($today) {
                $join->on('checklist_entries.checklist_item_id', '=', 'checklist_items.id')
                    ->whereDate('checklist_entries.created_at', '=', $today);
            })
            ->leftJoin('periods', 'checklist_entries.period_id', '=', 'periods.id') // Join periods table
            ->select([
                'checklist_categories.id',
                'checklist_categories.name',
                'periods.id as period_id',  // Include period ID
                'periods.label as period_label', // Include period name (or periods.time if needed)
                DB::raw('COUNT(checklist_entries.id) as checklist_entries_count')
            ])
            ->groupBy(['checklist_categories.id', 'checklist_categories.name', 'periods.id', 'periods.label']) // Group by period
            ->get();

        $entriesCountByPeriod = Period::select([
                'periods.id as period_id',
                'periods.label as period_label',
                DB::raw('COUNT(checklist_entries.id) as checklist_entries_count'),
                DB::raw('SUM(checklist_items.id IS NOT NULL) as checklist_items_count') // Count checklist items per period
            ])
            ->leftJoin('checklist_entries', function ($join) use ($today) {
                $join->on('checklist_entries.period_id', '=', 'periods.id')
                     ->whereDate('checklist_entries.created_at', '=', $today);
            })
            ->leftJoin('checklist_items', 'checklist_entries.checklist_item_id', '=', 'checklist_items.id')
            ->groupBy('periods.id', 'periods.label')
            ->get();
        
        $itemsCountByPeriod = DB::table('checklist_entries')
            ->join('checklist_items', 'checklist_entries.checklist_item_id', '=', 'checklist_items.id')
            ->join('periods', 'checklist_entries.period_id', '=', 'periods.id')
            ->select([
                'checklist_entries.period_id',
                DB::raw('COUNT(DISTINCT checklist_entries.checklist_item_id) as checklist_items_count')
            ])
            ->groupBy('checklist_entries.period_id')
            ->get();

        $totalItemsCount = \App\Models\ChecklistItem::count();

        

        $itemsCountBySubCategory = ChecklistSubcategory::leftJoin('checklist_items', 'checklist_items.checklist_subcategory_id', '=', 'checklist_subcategories.id')
            ->select(['checklist_subcategories.id', 'checklist_subcategories.name', DB::raw('COUNT(checklist_items.id) as checklist_items_count')])
            ->groupBy(['checklist_subcategories.id', 'checklist_subcategories.name'])
            ->get();
        
        $entriesCountBySubCategory = ChecklistSubcategory::leftJoin('checklist_items', 'checklist_items.checklist_subcategory_id', '=', 'checklist_subcategories.id')
        ->leftJoin('checklist_entries', function ($join) use ($currentPeriod, $today)
        {
            $join->on('checklist_entries.checklist_item_id', '=', 'checklist_items.id')
                ->whereDate('checklist_entries.created_at', '=', $today);
        })
        ->select(['checklist_subcategories.id', 'checklist_subcategories.name', DB::raw('COUNT(checklist_entries.id) as checklist_entries_count')])
        ->groupBy(['checklist_subcategories.id', 'checklist_subcategories.name'])
        ->get();

        return view('beranda', [
            'periods' => $periods,
            'items_count_by_category' => $itemsCountByCategory,
            'entries_count_by_category' => $entriesCountByCategory,
            'items_count_by_subcategory' => $itemsCountBySubCategory,
            'entries_count_by_subcategory' => $entriesCountBySubCategory,
            'entries_count_by_category_today' => $entriesCountByCategoryToday,
            'entries_count_by_period' => $entriesCountByPeriod,
            'items_count_by_period' => $itemsCountByPeriod,
            'total_items_count' => $totalItemsCount
        ]);
    }
}
