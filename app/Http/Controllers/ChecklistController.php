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

        $checklist_items = ChecklistItem::where('category_id', $category_id)
            ->with('subcategory')
            ->get()
            ->groupBy('subcategory_id');

        $periods = Period::all();
        $periods = $periods->map(function ($period)
        {
            $period->period_start_time = substr($period->period_start_time, 0, 5); // Remove seconds
            $period->period_end_time = substr($period->period_end_time, 0, 5); // Remove seconds
            return $period;
        });

        $entry_values = EntryValue::where('category_id', $category_id)->get();


        return view($view, compact('checklist_items', 'category_identifier', 'periods', 'entry_values'));
    }
}
