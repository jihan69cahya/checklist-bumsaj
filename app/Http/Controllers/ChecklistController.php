<?php

namespace App\Http\Controllers;

use App\Models\ChecklistCategory;
use App\Models\ChecklistEntry;
use App\Models\ChecklistItem;
use App\Models\EntryValue;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $checklist_category = ChecklistCategory::find($category_id);

        $checklist_items = ChecklistItem::where('checklist_category_id', $category_id)
            ->with('checklist_subcategory')
            ->get()
            ->groupBy('checklist_subcategory_id');

        $currentTime = now('Asia/Jakarta')->format('H:i:s');
        $periods = Period::all()->filter(function ($period) use ($currentTime)
        {
            return $period->start_time <= $currentTime;
        })->map(function ($period)
        {
            $period->start_time = substr($period->start_time, 0, 5);
            $period->end_time = substr($period->end_time, 0, 5);
            return $period;
        });

        $entry_values = EntryValue::where('checklist_category_id', $category_id)->get();

        return view('checklist', compact('checklist_items', 'periods', 'entry_values', 'checklist_category'));
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

    public function clearEntryValue(Request $request)
    {
        $itemId = $request->input('item_id');
        $periodId = $request->input('period_id');
        $entryDate = $request->input('entry_date');

        $entry = ChecklistEntry::where('checklist_item_id', $itemId)
            ->where('period_id', $periodId)
            ->where('entry_date', $entryDate)
            ->first();

        if ($entry)
        {
            $entry->delete();
            return response()->json([
                'success' => true,
                'message' => 'Entry deleted successfully.',
                'data' => $entry
            ]);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'No entry found to delete.',
                'request' => [
                    'checklist_item_id' => $itemId,
                    'period_id' => $periodId,
                    'entry_date' => $entryDate,
                ]
            ], 404);
        }
    }

    public function saveEntryValues(Request $request)
    {
        $validatedData = $request->validate([
            'entries' => 'required|array',
            'entries.*.item_id' => 'required|integer',
            'entries.*.entry_value_id' => 'required|integer',
            'entries.*.period_id' => 'required|integer',
            'entries.*.entry_date' => 'required|date',
            'entries.*.entry_time' => 'required|date_format:H:i:s',
        ]);

        $userId = Auth::id();

        if (!$userId)
        {
            return response()->json(['success' => false, 'error' => 'User not authenticated.'], 401);
        }

        DB::beginTransaction();
        try
        {
            foreach ($validatedData['entries'] as $entryData)
            {
                ChecklistEntry::updateOrCreate(
                    [
                        'checklist_item_id' => $entryData['item_id'],
                        'period_id' => $entryData['period_id'],
                        'entry_date' => $entryData['entry_date'],
                    ],
                    [
                        'user_id' => $userId,
                        'checklist_item_id' => $entryData['item_id'],
                        'period_id' => $entryData['period_id'],
                        'entry_value_id' => $entryData['entry_value_id'],
                        'entry_date' => $entryData['entry_date'],
                        'entry_time' => $entryData['entry_time'],
                    ]
                );
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Entries saved successfully.']);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            Log::error('Error saving entry values:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
