<?php

namespace App\Http\Controllers;

use App\Models\ChecklistCategory;
use App\Models\ChecklistSubcategory;
use App\Models\ChecklistEntry;
use App\Models\EntryValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class RekapitulasiController extends Controller
{
    public function showRekapitulasi(Request $request)
    {
        $categoryId = $request->get('category_id', 1);
        $startDate = $request->get('start_date', today()->format('Y-m-d'));
        $endDate = $request->get('end_date', today()->format('Y-m-d'));

        // Ambil subkategori berdasarkan kategori checklist
        $subcategories = ChecklistSubcategory::where('checklist_category_id', $categoryId)->get();

        // Ambil semua entry_values yang terkait dengan kategori yang dipilih
        $entry_values = EntryValue::where('checklist_category_id', $categoryId)->get();

        // Ambil jumlah entry berdasarkan item_id dan entry_value_id
        $entries = ChecklistEntry::whereIn('checklist_item_id', $subcategories->pluck('id'))
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->select('checklist_item_id', 'entry_value_id', DB::raw('count(*) as total'))
            ->groupBy('checklist_item_id', 'entry_value_id')
            ->get()
            ->groupBy('checklist_item_id')
            ->map(fn($items) => $items->pluck('total', 'entry_value_id')->toArray());

        return view('rekapitulasi', compact('subcategories', 'entries', 'categoryId', 'entry_values'));
    }

    public function downloadCSV(Request $request)
    {
        $categoryId = $request->get('category_id', 1);
        $category = ChecklistCategory::findOrFail($categoryId);
        $startDate = $request->get('start_date', today()->format('Y-m-d'));
        $endDate = $request->get('end_date', today()->format('Y-m-d'));

        $subcategories = $category->subcategories;
        $entry_values = $category->entry_values;

        $entries = ChecklistEntry::whereIn('checklist_item_id', $subcategories->pluck('id'))
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->select('checklist_item_id', 'entry_value_id', DB::raw('count(*) as total'))
            ->groupBy('checklist_item_id', 'entry_value_id')
            ->get()
            ->groupBy('checklist_item_id')
            ->map(fn($items) => $items->pluck('total', 'entry_value_id')->toArray());

        $response = new StreamedResponse(function () use ($subcategories, $entries, $entry_values)
        {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Nama Ruangan', ...$entry_values->pluck('value_code')->toArray()]);

            foreach ($subcategories as $subcategory)
            {
                fputcsv($handle, [
                    $subcategory->subcategory_name,
                    ...array_map(fn($entry_value) => $entries[$subcategory->id][$entry_value->id] ?? 0, $entry_values)
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="rekapitulasi.csv"');

        return $response;
    }

    public function downloadXls(Request $request)
    {
        $categoryId = $request->get('category_id', 1);
        $category = ChecklistCategory::findOrFail($categoryId);
        $startDate = $request->get('start_date', today()->format('Y-m-d'));
        $endDate = $request->get('end_date', today()->format('Y-m-d'));

        $subcategories = $category->subcategories;
        $entry_values = $category->entry_values;

        $entries = ChecklistEntry::whereIn('checklist_item_id', $subcategories->pluck('id'))
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->select('checklist_item_id', 'entry_value_id', DB::raw('count(*) as total'))
            ->groupBy('checklist_item_id', 'entry_value_id')
            ->get()
            ->groupBy('checklist_item_id')
            ->map(fn($items) => $items->pluck('total', 'entry_value_id')->toArray());

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $header = ['Nama Ruangan', ...$entry_values->pluck('value_code')->toArray()];
        $sheet->fromArray([$header], null, 'A1');

        $row = 2;
        foreach ($subcategories as $subcategory)
        {
            $sheet->fromArray(
                [
                    $subcategory->name,
                    ...$entry_values->map(fn($entry_value) => $entries[$subcategory->id][$entry_value->id] ?? '0')->toArray(),
                ],
                null,
                "A$row"
            );
            $row++;
        }

        // Formatting
        $sheet->getStyle("A1:Z1")->getFont()->setBold(true);
        foreach (range('A', 'Z') as $col)
        {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // File
        $filename = "rekapitulasi_" . str_replace(' ', '_', $category->name) . "_{$startDate}_{$endDate}.xls";
        $writer = new Xls($spreadsheet);

        $response = new StreamedResponse(function () use ($writer)
        {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }
}
