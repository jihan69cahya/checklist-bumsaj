<?php

namespace App\Http\Controllers;

use App\Models\ChecklistCategory;
use App\Models\ChecklistSubcategory;
use App\Models\ChecklistEntry;
use App\Models\ChecklistItem;
use App\Models\EntryValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RekapitulasiController extends Controller
{
    public function showRekapitulasi(Request $request)
    {
        $categoryId = $request->get('category_id', 1);
        $startDate = $request->get('start_date', today()->format('Y-m-d'));
        $endDate = $request->get('end_date', today()->format('Y-m-d'));

        $subcategories = ChecklistSubcategory::where('checklist_category_id', $categoryId)->get();

        $entry_values = EntryValue::where('checklist_category_id', $categoryId)->get();

        $items = ChecklistItem::with('checklist_subcategory')
            ->whereHas('checklist_subcategory', fn($q) => $q->where('checklist_category_id', $categoryId))
            ->get()
            ->keyBy('id');

        $rawEntries = ChecklistEntry::whereIn('checklist_item_id', $items->keys())
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->get();

        $entries = [];

        foreach ($rawEntries as $entry) {
            $item = $items[$entry->checklist_item_id];
            $subcategoryId = $item->checklist_subcategory_id;
            $entryValueId = $entry->entry_value_id;

            if (!isset($entries[$subcategoryId][$entryValueId])) {
                $entries[$subcategoryId][$entryValueId] = 0;
            }
            $entries[$subcategoryId][$entryValueId]++;
        }
        return view('rekapitulasi', [
            'subcategories' => $subcategories,
            'entry_values' => $entry_values,
            'entries' => $entries,
            'categoryId' => $categoryId,
        ]);
    }

    public function downloadXls(Request $request)
    {
        $categoryId = $request->get('category_id', 1);
        $category = ChecklistCategory::findOrFail($categoryId);
        $startDate = $request->get('start_date', today()->format('Y-m-d'));
        $endDate = $request->get('end_date', today()->format('Y-m-d'));

        $subcategories = $category->subcategories()->with('items')->get();
        $entries = ChecklistEntry::whereIn('checklist_item_id', $subcategories->pluck('items')->flatten()->pluck('id')->unique())
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->where('is_validate', 1)
            ->select('checklist_item_id', 'entry_value_id', DB::raw('count(*) as total'))
            ->groupBy('checklist_item_id', 'entry_value_id')
            ->get()
            ->groupBy('checklist_item_id')
            ->map(fn($items) => $items->pluck('total', 'entry_value_id')->toArray());

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $dayMap = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu'
        ];
        $hari = $dayMap[now()->format('l')] ?? now()->format('l');

        // Judul
        $sheet->setCellValue('A1', "CHECKLIST KONDISI " . strtoupper($category->name));
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->setName('Times New Roman');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', "BANDAR UDARA MUTIARA SIS AL-JUFRI PALU");
        $sheet->mergeCells('A2:E2');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14)->setName('Times New Roman');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Tanggal
        $sheet->setCellValue('A4', "HARI: {$hari}");
        $sheet->setCellValue('A5', 'TANGGAL: ' . now()->format('d-m-Y'));
        $sheet->getStyle('A4')->getFont()->setSize(12)->setName('Times New Roman');
        $sheet->getStyle('A5')->getFont()->setSize(12)->setName('Times New Roman');

        // **LOGIKA FORMAT TABEL BERDASARKAN KATEGORI**
        $columnFormats = [
            1 => ['No', 'Ruangan', 'B', 'RK'],         // Category 1
            2 => ['No', 'Ruangan', 'B', 'KB', 'K'],   // Category 2
            3 => ['No', 'Ruangan', 'P', 'L']          // Category 3
        ];

        $categoryType = $category->id ?? 1;
        $headers = $columnFormats[$categoryType] ?? $columnFormats[1];
        $lastColumn = chr(65 + count($headers) - 1); // Hitung posisi kolom akhir (A-Z)

        // **Header Tabel**
        $sheet->fromArray([$headers], null, 'A7');
        $sheet->getStyle("A7:{$lastColumn}7")->getFont()->setBold(true)->setName('Times New Roman')->setSize(12);
        $sheet->getStyle("A7:{$lastColumn}7")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("A7:{$lastColumn}7")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // **Mengisi Data Checklist**
        $row = 8;
        $no = 1;
        foreach ($subcategories as $subcategory) {
            $sheet->setCellValue("A$row", join(" ", [$no++, $subcategory->name]));
            $sheet->getStyle("A$row:D$row")->getFont()->setBold(true);
            $sheet->mergeCells("A$row:D$row");
            $sheet->getStyle("A$row:D$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $row++;

            foreach ($subcategory->items ?? collect() as $item) {
                if ($categoryType == 1) {
                    $baik = $entries[$item->id][1] ?? '0';
                    $rusak = $entries[$item->id][2] ?? '0';
                    $data = [" ", $item->name, $baik, $rusak];
                } elseif ($categoryType == 2) {
                    $bersih = $entries[$item->id][3] ?? '0';
                    $kurangBersih = $entries[$item->id][4] ?? '0';
                    $kotor = $entries[$item->id][5] ?? '0';
                    $data = [" ", $item->name, $bersih, $kurangBersih, $kotor];
                } elseif ($categoryType == 3) {
                    $padat = $entries[$item->id][6] ?? '0';
                    $lancar = $entries[$item->id][7] ?? '0';
                    $data = [" ", $item->name, $padat, $lancar];
                }

                $sheet->fromArray([$data], null, "A$row");

                $range2 = "A$row:$lastColumn$row";
                $sheet->getStyle($range2)
                    ->getFont()->setSize(12)->setName('Times New Roman');
                foreach (range('A', $lastColumn) as $col) {
                    if ($col === 'B') {
                        // Kolom B (Ruangan) rata kiri
                        $sheet->getStyle("$col$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    } else {
                        // Kolom lain rata tengah
                        $sheet->getStyle("$col$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }
                }
                $row++;
            }

            foreach (range('A', $lastColumn) as $col) {
                if ($col === 'B') {
                    // Kolom B (Ruangan) rata kiri
                    $sheet->getStyle("$col$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                } else {
                    // Kolom lain rata tengah
                    $sheet->getStyle("$col$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }
            }
        }

        $sheet->getStyle("A7:{$lastColumn}" . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(50);
        foreach (range('C', $lastColumn) as $col) {
            $sheet->getColumnDimension($col)->setWidth(10);
        }

        $signatureRow = $row + 1;
        $categoryNotes = [
            1 => "KET:  B: Baik     RK: Rusak",
            2 => "KET:  B: Bersih     KB: Kurang Bersih     K: Kotor",
            3 => "KET:  P: Padat     L: Lancar"
        ];

        $sheet->setCellValue("A{$signatureRow}", $categoryNotes[$categoryType] ?? '');
        $sheet->setCellValue("A" . ($signatureRow + 2), "Mengetahui");
        $sheet->setCellValue("A" . ($signatureRow + 3), "Koordinator {$category->name}");
        $sheet->setCellValue("A" . ($signatureRow + 4), "Hygiene & Sanitasi");
        $sheet->setCellValue("A" . ($signatureRow + 8), "Romi Yosep Sigar");

        foreach (["A" . ($signatureRow + 2), "A" . ($signatureRow + 3), "A" . ($signatureRow + 4), "A" . ($signatureRow + 6)] as $boldCell) {
            $sheet->getStyle($boldCell)->getFont()->setBold(true)->setSize(12)->setName('Times New Roman');
        }

        $sheet->getStyle("A7:$lastColumn" . ($signatureRow + 8))
            ->getFont()->setSize(12)->setName('Times New Roman');

        $spreadsheet->getActiveSheet()->setSelectedCell('');



        // **Export ke Excel**
        $filename = "rekapitulasi_" . str_replace(' ', '_', $category->name) . "_{$startDate}_{$endDate}.xls";
        $writer = new Xls($spreadsheet);

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }
}
