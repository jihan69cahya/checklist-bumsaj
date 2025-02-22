<?php

namespace App\Http\Controllers;

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
        return view($view, compact('checklist_items', 'category_identifier', 'periods', 'entry_values'));
    }
}
