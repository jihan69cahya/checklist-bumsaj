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
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RekapitulasiController extends Controller
{
    public function showRekapitulasi(Request $request)
    {
        // Get the category ID from the request, default to 1 if not provided
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

    

    public function downloadXls(Request $request)
    {
        $categoryId = $request->get('category_id', 1);
        $category = ChecklistCategory::findOrFail($categoryId);
        $startDate = $request->get('start_date', today()->format('Y-m-d'));
        $endDate = $request->get('end_date', today()->format('Y-m-d'));

        $subcategories = $category->subcategories;
        $entries = ChecklistEntry::whereIn('checklist_item_id', $subcategories->pluck('id'))
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->select('checklist_item_id', 'entry_value_id', DB::raw('count(*) as total'))
            ->groupBy('checklist_item_id', 'entry_value_id')
            ->get()
            ->groupBy('checklist_item_id')
            ->map(fn($items) => $items->pluck('total', 'entry_value_id')->toArray());

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Konversi nama hari ke Bahasa Indonesia
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
            if ($categoryType == 1) {
                $baik = $entries[$subcategory->id][1] ?? '0';
                $rusak = $entries[$subcategory->id][2] ?? '0';
                $data = [$no++, $subcategory->name, $baik, $rusak];
            } elseif ($categoryType == 2) {
                $bersih = $entries[$subcategory->id][1] ?? '0';
                $kurangBersih = $entries[$subcategory->id][2] ?? '0';
                $kotor = $entries[$subcategory->id][3] ?? '0';
                $data = [$no++, $subcategory->name, $bersih, $kurangBersih, $kotor];
            } elseif ($categoryType == 3) {
                $padat = $entries[$subcategory->id][1] ?? '0';
                $lancar = $entries[$subcategory->id][2] ?? '0';
                $data = [$no++, $subcategory->name, $padat, $lancar];
            }
        
            // Memasukkan data ke dalam sheet
            $sheet->fromArray([$data], null, "A$row");
        
            // Tentukan kolom terakhir berdasarkan jumlah data
            $lastColumn = chr(65 + count($data) - 1);
            $range = "A$row:$lastColumn$row";
        
            // Styling untuk font
            $sheet->getStyle($range)
                ->getFont()->setSize(12)->setName('Times New Roman');
        
            // Styling alignment
            foreach (range('A', $lastColumn) as $col) {
                if ($col === 'B') {
                    // Kolom B (Ruangan) rata kiri
                    $sheet->getStyle("$col$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                } else {
                    // Kolom lain rata tengah
                    $sheet->getStyle("$col$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }
            }
        
            // Styling border
            $sheet->getStyle($range)
                ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        
            $row++;
        }
        

        // **Border untuk seluruh tabel**
        $sheet->getStyle("A7:{$lastColumn}" . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // **Menyesuaikan lebar kolom**
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(50);
        foreach (range('C', $lastColumn) as $col) {
            $sheet->getColumnDimension($col)->setWidth(10);
        }

        // **Keterangan kategori**
        $signatureRow = $row + 2;
        $categoryNotes = [
            1 => "KET:  B: Baik     RK: Rusak",
            2 => "KET:  B: Bersih     KB: Kurang Bersih     K: Kotor",
            3 => "KET:  P: Padat     L: Lancar"
        ];
        $sheet->setCellValue("A{$signatureRow}", $categoryNotes[$categoryType] ?? '');
        $sheet->getStyle("A{$signatureRow}")
            ->getFont()->setSize(12)->setName('Times New Roman');

        // **Tanda Tangan**
        $sheet->setCellValue("A" . ($signatureRow + 2), "Mengetahui");
        $sheet->setCellValue("A" . ($signatureRow + 3), "Koordinator {$category->name}");
        $sheet->setCellValue("A" . ($signatureRow + 4), "Hygiene & Sanitasi");
        $sheet->setCellValue("A" . ($signatureRow + 6), auth()->user()->name);

        foreach (["A" . ($signatureRow + 2), "A" . ($signatureRow + 3), "A" . ($signatureRow + 4), "A" . ($signatureRow + 6)] as $boldCell) {
            $sheet->getStyle($boldCell)->getFont()->setBold(true)->setSize(12)->setName('Times New Roman');
        }

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
