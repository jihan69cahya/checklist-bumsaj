<?php

namespace Database\Seeders;

use App\Models\ChecklistItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChecklistItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $checklistItems = [
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 1,
                'name' => 'Trolley',
                'description' => null,
                'keterangan' => '30 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 1,
                'name' => 'FIDS',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 1,
                'name' => 'CCTV',
                'description' => null,
                'keterangan' => '4 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 1,
                'name' => 'FIDS Lobby Informasi',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 1,
                'name' => 'CCTV Lobby Informasi',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 1,
                'name' => 'Tempat Sampah',
                'description' => null,
                'keterangan' => '2 kotak'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'X-Ray SCP 1',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'Kursi Petugas X-Ray',
                'description' => null,
                'keterangan' => '4 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'Walk Through SCP 1',
                'description' => null,
                'keterangan' => '3 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'FIDS',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'CCTV',
                'description' => null,
                'keterangan' => '8 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'AC Central',
                'description' => null,
                'keterangan' => '9 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'AC Standing',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'Monitor Check In Counter',
                'description' => null,
                'keterangan' => '20 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'Meja dan Kursi Check In Counter',
                'description' => null,
                'keterangan' => '20 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'Conveyor Belt Label',
                'description' => null,
                'keterangan' => '18 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'Conveyor Belt Check In',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'Tempat Sampah',
                'description' => null,
                'keterangan' => '1 kotak'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'X-Ray SCP 2',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'Kursi Petugas X-Ray',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'Walk Through SCP 2',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'FIDS SCP 2',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'CCTV SCP 2',
                'description' => null,
                'keterangan' => '3 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 2,
                'name' => 'AC Central SCP 2',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 3,
                'name' => 'Lift Disabilitas',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 3,
                'name' => 'Eskalator',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 3,
                'name' => 'Kursi',
                'description' => null,
                'keterangan' => '327 seat'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 3,
                'name' => 'FIDS',
                'description' => null,
                'keterangan' => '2 unit (TV 1 unit)'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 3,
                'name' => 'CCTV',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 3,
                'name' => 'AC Central',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 3,
                'name' => 'Monitor BMKG',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 3,
                'name' => 'Monitor Gate',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 3,
                'name' => 'Meja Cek Boarding Pass',
                'description' => null,
                'keterangan' => '4 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 3,
                'name' => 'Kursi Cek Boarding Pass',
                'description' => null,
                'keterangan' => '4 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 3,
                'name' => 'Charging Station',
                'description' => null,
                'keterangan' => '4 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 3,
                'name' => 'Tempat Sampah',
                'description' => null,
                'keterangan' => '1 kotak'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 4,
                'name' => 'Kursi',
                'description' => null,
                'keterangan' => '40 seat'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 4,
                'name' => 'Meja',
                'description' => null,
                'keterangan' => '15 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 4,
                'name' => 'FIDS',
                'description' => null,
                'keterangan' => '1 unit (TV 1 unit)'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 4,
                'name' => 'CCTV',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 4,
                'name' => 'AC Central',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 4,
                'name' => 'AC Standing',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 4,
                'name' => 'Monitor Gate',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 4,
                'name' => 'Ruang Merokok',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 4,
                'name' => 'Kursi Ruang Merokok',
                'description' => null,
                'keterangan' => '6 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 4,
                'name' => 'Meja Ruang Merokok',
                'description' => null,
                'keterangan' => '6 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 4,
                'name' => 'Exhaust Fan Ruang Merokok',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 4,
                'name' => 'Air Purifier Ruang Merokok',
                'description' => null,
                'keterangan' => '3 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 4,
                'name' => 'Tempat Sampah Ruang Merokok',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 4,
                'name' => 'Asbak Ruang Merokok',
                'description' => null,
                'keterangan' => '3 buah'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 5,
                'name' => 'Kursi',
                'description' => null,
                'keterangan' => '626 seat'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 5,
                'name' => 'FIDS',
                'description' => null,
                'keterangan' => '7 unit (TV 3 unit)'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 5,
                'name' => 'CCTV',
                'description' => null,
                'keterangan' => '14 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 5,
                'name' => 'AC Central',
                'description' => null,
                'keterangan' => '20 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 5,
                'name' => 'CCTV Garbarata',
                'description' => null,
                'keterangan' => '7 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 5,
                'name' => 'AC Garbarata',
                'description' => null,
                'keterangan' => '9 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 5,
                'name' => 'Monitor Gate',
                'description' => null,
                'keterangan' => '4 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 5,
                'name' => 'Meja Cek Boarding Pass',
                'description' => null,
                'keterangan' => '8 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 5,
                'name' => 'Kursi Cek Boarding Pass',
                'description' => null,
                'keterangan' => '8 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 5,
                'name' => 'Charging Station',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 5,
                'name' => 'Baby Stroller',
                'description' => null,
                'keterangan' => '4 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 5,
                'name' => 'Tempat Sampah',
                'description' => null,
                'keterangan' => '2 kotak'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 6,
                'name' => 'Trolley',
                'description' => null,
                'keterangan' => '98 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 6,
                'name' => 'FIDS',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 6,
                'name' => 'CCTV',
                'description' => null,
                'keterangan' => '9 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 6,
                'name' => 'AC Central',
                'description' => null,
                'keterangan' => '10 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 6,
                'name' => 'Lift Disabilitas',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 6,
                'name' => 'Eskalator',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 6,
                'name' => 'Monitor Baggage Claim',
                'description' => null,
                'keterangan' => '3 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 6,
                'name' => 'Conveyor Belt Bagasi',
                'description' => null,
                'keterangan' => '3 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 6,
                'name' => 'Kursi',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 6,
                'name' => 'Lift Barang',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 7,
                'name' => 'FIDS',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 7,
                'name' => 'CCTV',
                'description' => null,
                'keterangan' => '3 unit'
            ],
            [
                'checklist_category_id' => 1,
                'checklist_subcategory_id' => 7,
                'name' => 'Tempat Sampah',
                'description' => null,
                'keterangan' => '1 kotak'
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 8,
                'name' => 'Area Drop Zone',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 8,
                'name' => 'Area Lobby Keberangkatan',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 9,
                'name' => 'Area Check-In Counter',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 9,
                'name' => 'Area Conveyor Belt Label',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 9,
                'name' => 'Area SCP 1',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 9,
                'name' => 'Area SCP 2',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 9,
                'name' => 'Ruang Perkantoran Airlines',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 9,
                'name' => 'Ruang KKP',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 10,
                'name' => 'Area Ruang Tunggu',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 10,
                'name' => 'Pintu / Dinding Kaca',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 10,
                'name' => 'Musholla',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 10,
                'name' => 'Toilet',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 10,
                'name' => 'Eskalator',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 10,
                'name' => 'Tangga Manual',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 10,
                'name' => 'Lift Disabilitas',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 10,
                'name' => 'Ruang Disabilitas',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 10,
                'name' => 'Ruang Laktasi',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 10,
                'name' => 'Kantin / Tenant',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 11,
                'name' => 'Area Ruang VIP',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 11,
                'name' => 'Musholla',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 11,
                'name' => 'Ruang Merokok',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 11,
                'name' => 'Toilet',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 12,
                'name' => 'Area Ruang Tunggu',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 12,
                'name' => 'Pintu / Dinding Kaca',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 12,
                'name' => 'Musholla',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 12,
                'name' => 'Toilet',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 12,
                'name' => 'Tempat Bermain Anak',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 12,
                'name' => 'Ruang Disabilitas',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 12,
                'name' => 'Ruang Laktasi',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 12,
                'name' => 'Kantin / Tenant',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 13,
                'name' => 'Area Garbarata 1',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 13,
                'name' => 'Area Garbarata 2',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 13,
                'name' => 'Area Garbarata 3',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 13,
                'name' => 'Pintu / Dinding Kaca',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 14,
                'name' => 'Area Ruang Kedatangan',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 14,
                'name' => 'Pintu / Dinding Kaca',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 14,
                'name' => 'Area Conveyor',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 14,
                'name' => 'Eskalator',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 14,
                'name' => 'Tangga Manual',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 14,
                'name' => 'Lift Disabilitas',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 14,
                'name' => 'Toilet',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 14,
                'name' => 'Ruang Lost and Found',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 15,
                'name' => 'Area Pickup Zone',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 15,
                'name' => 'Area Lobby Kedatangan',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 15,
                'name' => 'Musholla',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 2,
                'checklist_subcategory_id' => 15,
                'name' => 'Toilet',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 3,
                'checklist_subcategory_id' => 16,
                'name' => 'Area Drop Zone Atas',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 3,
                'checklist_subcategory_id' => 16,
                'name' => 'Area Drop Zone Bawah',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 3,
                'checklist_subcategory_id' => 17,
                'name' => 'Area Pick-Up Zone Atas',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 3,
                'checklist_subcategory_id' => 17,
                'name' => 'Area Pick-Up Zone Bawah',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 3,
                'checklist_subcategory_id' => 18,
                'name' => 'Keberangkatan',
                'description' => null,
                'keterangan' => null
            ],
            [
                'checklist_category_id' => 3,
                'checklist_subcategory_id' => 18,
                'name' => 'Kedatangan',
                'description' => null,
                'keterangan' => null
            ],
        ];

        foreach ($checklistItems as $item)
        {
            ChecklistItem::create($item);
        }
    }
}
