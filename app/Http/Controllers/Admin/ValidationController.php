<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChecklistCategory;
use App\Models\ChecklistEntry;
use App\Models\ChecklistItem;
use App\Models\EntryValue;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidationController extends Controller
{
    public function show($category_identifier)
    {
        $categoryMap = [
            'fasilitas-gedung-terminal' => ['category_id' => 1, 'view' => 'checklists.fasilitas'],
            'kebersihan-gedung-terminal' => ['category_id' => 2, 'view' => 'checklists.kebersihan'],
            'curbside-area' => ['category_id' => 3, 'view' => 'checklists.curbside']
        ];

        if (!array_key_exists($category_identifier, $categoryMap)) {
            abort(404);
        }

        $category_id = $categoryMap[$category_identifier]['category_id'];

        $checklist_items = ChecklistItem::where('checklist_category_id', $category_id)
            ->with('checklist_subcategory')
            ->get()
            ->groupBy('checklist_subcategory_id');

        $itemIds = $checklist_items->flatten()->pluck('id');

        $checklist_entries = ChecklistEntry::whereIn('checklist_item_id', $itemIds)
            ->with(['checklist_item', 'checklist_item.checklist_subcategory', 'user'])
            ->orderBy('is_validate')
            ->get()
            ->groupBy(function ($entry) {
                return \Carbon\Carbon::parse($entry->entry_date)->format('Y-m-d');
            });

        $data = [];

        foreach ($checklist_entries as $tanggal => $entries) {
            $groupedByUser = $entries->groupBy('user_id');

            foreach ($groupedByUser as $user_id => $userEntries) {
                $user = $userEntries->first()->user;

                $data[] = [
                    'user_name' => $user->name,
                    'total_periode' => $userEntries->pluck('period_id')->unique()->count(),
                    'is_validate' => $userEntries->first()->is_validate,
                    'tanggal' => $tanggal,
                ];
            }
        }
        $periode = Period::count();

        return view('admin.validation', compact('data', 'periode', 'category_id', 'category_identifier'));
    }

    public function validation(Request $request)
    {
        $category_id = $request->category_id;
        $tanggal = $request->tanggal;

        DB::beginTransaction();

        try {
            $checklist_items = ChecklistItem::where('checklist_category_id', $category_id)
                ->with('checklist_subcategory')
                ->get()
                ->groupBy('checklist_subcategory_id');

            $itemIds = $checklist_items->flatten()->pluck('id');

            ChecklistEntry::whereIn('checklist_item_id', $itemIds)
                ->where('entry_date', $tanggal)
                ->update(['is_validate' => 1]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Validasi berhasil.']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function detail($tanggal, $category_id, $category)
    {
        $checklist_category = ChecklistCategory::find($category_id);

        $checklist_items = ChecklistItem::where('checklist_category_id', $category_id)
            ->with('checklist_subcategory')
            ->get()
            ->groupBy('checklist_subcategory_id');

        $periods = Period::all();

        $entry_values = EntryValue::where('checklist_category_id', $category_id)->get();

        return view('admin.detail', compact('checklist_items', 'periods', 'entry_values', 'checklist_category', 'tanggal', 'category'));
    }
}
