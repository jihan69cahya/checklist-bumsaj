<?php

namespace App\Http\Controllers;

use App\Models\ChecklistEntry;
use App\Models\ChecklistItem;
use App\Models\EntryValue;
use App\Models\Period;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function show($category_identifier)
    {
        $categoryMap = [
            'fasilitas-gedung-terminal' => ['category_id' => 1, 'view' => 'checklists.fasilitas'],
            'kebersihan-gedung-terminal' => ['category_id' => 2, 'view' => 'checklists.kebersihan'],
            'curbside-area' => ['category_id' => 3, 'view' => 'checklists.curbside']
        ];

        if (!array_key_exists($category_identifier, $categoryMap))
        {
            abort(404);
        }

        $category_id = $categoryMap[$category_identifier]['category_id'];
        $view = $categoryMap[$category_identifier]['view'];

        $checklist_items = ChecklistItem::where('checklist_category_id', $category_id)
            ->with('checklist_subcategory')
            ->get()
            ->groupBy('checklist_subcategory_id');


        $periods = Period::all();
        $periods = $periods->map(function ($period)
        {
            $period->start_time = substr($period->start_time, 0, 5);
            $period->end_time = substr($period->end_time, 0, 5);
            return $period;
        });

        $entry_values = EntryValue::where('checklist_category_id', $category_id)->get();

        // Pass data to the view
        return view($view, compact('checklist_items', 'category_identifier', 'periods', 'entry_values', 'category_id'));
    }

    public function getEntriesByPeriod(Request $request)
    {
        $request->validate([
            'checklist_category_id' => 'required|integer|exists:checklist_categories,id',
            'period_id' => 'required|integer|exists:periods,id',
            'entry_date' => 'required|date',
        ]);

        $categoryId = $request->input('checklist_category_id');
        $periodId = $request->input('period_id');
        $entryDate = $request->input('entry_date');

        $entries = ChecklistEntry::where('period_id', $periodId)
            ->where('entry_date', $entryDate)
            ->whereHas('checklist_item', function ($query) use ($categoryId)
            {
                $query->where('checklist_category_id', $categoryId);
            })
            ->with('checklist_item.checklist_subcategory')
            ->get();

        return response()->json($entries);
    }

    public function saveEntryValue(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer|exists:checklist_items,id',
            'entry_value_id' => 'required|integer|exists:entry_values,id',
            'period_id' => 'required|integer|exists:periods,id',
            'entry_date' => 'required|date',
        ]);

        $entry = ChecklistEntry::updateOrCreate(
            [
                'checklist_item_id' => $request->item_id,
                'period_id' => $request->period_id,
                'entry_date' => $request->entry_date,
            ],
            [
                'entry_value_id' => $request->entry_value_id,
            ]
        );

        return response()->json(['success' => true, 'entry' => $entry]);
    }
}
