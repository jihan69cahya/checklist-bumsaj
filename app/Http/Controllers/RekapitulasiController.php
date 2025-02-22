<?php

namespace App\Http\Controllers;

use App\Models\ChecklistCategory;
use App\Models\ChecklistSubcategory;
use App\Models\ChecklistEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Symfony\Component\HttpFoundation\StreamedResponse;


class RekapitulasiController extends Controller
{
    public function showRekapitulasi(Request $request)
    {
        $categoryId = $request->get('category_id', 1);
        $category = ChecklistCategory::find($categoryId);
        $startDate = $request->get('start_date', today()->format('Y-m-d'));
        $endDate = $request->get('end_date', today()->format('Y-m-d'));

        $subcategories = $category->subcategories;
        $entry_values = $category->entry_values;

        $entries = ChecklistEntry::whereIn('item_id', $subcategories->pluck('id'))
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->select('item_id', 'entry_value_id', DB::raw('count(*) as total'))
            ->groupBy('item_id', 'entry_value_id')
            ->get()
            ->groupBy('item_id')
            ->map(fn($items) => $items->pluck('total', 'entry_value_id')->toArray());

        return view('rekapitulasi', compact('subcategories', 'entries', 'categoryId', 'entry_values'));
    }

    public function downloadCSV(Request $request)
    {
        $categoryId = $request->get('category_id', 1);
        $category = ChecklistCategory::find($categoryId);
        $startDate = $request->get('start_date', today()->format('Y-m-d'));
        $endDate = $request->get('end_date', today()->format('Y-m-d'));

        $subcategories = $category->subcategories;
        $entry_values = $category->entry_values;

        $entries = ChecklistEntry::whereIn('item_id', $subcategories->pluck('id'))
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->select('item_id', 'entry_value_id', DB::raw('count(*) as total'))
            ->groupBy('item_id', 'entry_value_id')
            ->get()
            ->groupBy('item_id')
            ->map(fn($items) => $items->pluck('total', 'entry_value_id')->toArray());

        $response = new StreamedResponse(function () use ($subcategories, $entries, $entry_values) {
            $handle = fopen('php://output', 'w');

            // Buat Header CSV
            $header = ['Nama Ruangan'];
            foreach ($entry_values as $entry_value) {
                $header[] = $entry_value->value_code;
            }
            fputcsv($handle, $header);

            // Isi data CSV
            foreach ($subcategories as $subcategory) {
                $row = [$subcategory->subcategory_name];

                foreach ($entry_values as $entry_value) {
                    $row[] = $entries[$subcategory->id][$entry_value->id] ?? 0;
                }

                fputcsv($handle, $row);
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
        $category = ChecklistCategory::find($categoryId);
        $startDate = $request->get('start_date', today()->format('Y-m-d'));
        $endDate = $request->get('end_date', today()->format('Y-m-d'));

        $subcategories = $category->subcategories;
        $entry_values = $category->entry_values;

        $entries = ChecklistEntry::whereIn('item_id', $subcategories->pluck('id'))
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->select('item_id', 'entry_value_id', DB::raw('count(*) as total'))
            ->groupBy('item_id', 'entry_value_id')
            ->get()
            ->groupBy('item_id')
            ->map(fn($items) => $items->pluck('total', 'entry_value_id')->toArray());

        // Buat file spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header tabel
        $sheet->setCellValue('A1', 'Nama Ruangan');
        $column = 'B';
        foreach ($entry_values as $entry_value) {
            $sheet->setCellValue($column . '1', $entry_value->value_code);
            $column++;
        }

        // Data tabel
        $row = 2;
        foreach ($subcategories as $subcategory) {
            $sheet->setCellValue('A' . $row, $subcategory->subcategory_name);
            $column = 'B';
            foreach ($entry_values as $entry_value) {
                $value = $entries[$subcategory->id][$entry_value->id] ?? 0;
                $sheet->setCellValue($column . $row, $value);
                $column++;
            }
            $row++;
        }

        // Format file
        $sheet->getStyle('A1:' . $column . '1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        for ($col = 'B'; $col != $column; $col++) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Nama tempat dari kategori
        $placeName = str_replace(' ', '_', $category->category_name); // Ganti spasi dengan underscore

        // Format nama file
        $filename = "rekapitulasi_{$placeName}_{$startDate}_{$endDate}.xls";

        $writer = new Xls($spreadsheet);

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }

}
