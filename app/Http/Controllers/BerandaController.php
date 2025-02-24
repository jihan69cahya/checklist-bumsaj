<?php

namespace App\Http\Controllers;

use App\Models\ChecklistCategory;
use App\Models\ChecklistEntry;
use App\Models\ChecklistItem;
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
                    ->where('checklist_entries.period_id', '=', $currentPeriod->id)
                    ->whereDate('checklist_entries.created_at', '=', $today);
            })
            ->select(['checklist_categories.id', 'checklist_categories.name', DB::raw('COUNT(checklist_entries.id) as checklist_entries_count')])
            ->groupBy(['checklist_categories.id', 'checklist_categories.name'])
            ->get();

        return view('beranda', [
            'periods' => $periods,
            'items_count_by_category' => $itemsCountByCategory,
            'entries_count_by_category' => $entriesCountByCategory
        ]);
    }
}
