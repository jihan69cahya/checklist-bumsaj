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

        $allPeriods = Period::select('id', 'label')->get();
        $allCategories = ChecklistCategory::select('id', 'name')->get();

        $entriesCountByCategoryToday = ChecklistCategory::leftJoin('checklist_items', 'checklist_items.checklist_category_id', '=', 'checklist_categories.id')
            ->leftJoin('checklist_entries', function ($join) use ($today)
            {
                $join->on('checklist_entries.checklist_item_id', '=', 'checklist_items.id')
                    ->whereDate('checklist_entries.created_at', '=', $today);
            })
            ->leftJoin('periods', 'checklist_entries.period_id', '=', 'periods.id')
            ->select([
                'checklist_categories.id as category_id',
                'checklist_categories.name as category_name',
                'periods.id as period_id',
                'periods.label as period_label',
                DB::raw('COUNT(checklist_entries.id) as checklist_entries_count')
            ])
            ->groupBy(['checklist_categories.id', 'checklist_categories.name', 'periods.id', 'periods.label'])
            ->get();

        $groupedResults = [];
        foreach ($allPeriods as $period)
        {
            $periodId = $period->id;
            $groupedResults[$periodId] = [
                'period_label' => $period->label,
                'categories' => [],
            ];

            foreach ($allCategories as $category)
            {
                $categoryId = $category->id;
                $groupedResults[$periodId]['categories'][$categoryId] = [
                    'name' => $category->name,
                    'checklist_entries_count' => 0,
                ];
            }
        }

        foreach ($entriesCountByCategoryToday as $entry)
        {
            $periodId = $entry->period_id;
            $categoryId = $entry->category_id;

            if (isset($groupedResults[$periodId]['categories'][$categoryId]))
            {
                $groupedResults[$periodId]['categories'][$categoryId]['checklist_entries_count'] = $entry->checklist_entries_count;
            }
        }

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
            'grouped_results' => $groupedResults
        ]);
    }
}
