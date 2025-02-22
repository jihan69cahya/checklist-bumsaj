<?php

namespace App\Http\Controllers;

use App\Models\ChecklistItem;
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

        return view($view, compact('checklist_items', 'category_identifier', 'periods'));
    }
}
