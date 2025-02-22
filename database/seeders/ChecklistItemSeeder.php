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
                'category_id' => 1,
                'subcategory_id' => 1,
                'item_name' => 'Trolley',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 1,
                'item_name' => 'FIDS',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 1,
                'item_name' => 'CCTV',
                'description' => null,
                'keterangan' => '4 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 1,
                'item_name' => 'FIDS Lobby Informasi',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 1,
                'item_name' => 'CCTV Lobby Informasi',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 1,
                'item_name' => 'Tempat Sampah',
                'description' => null,
                'keterangan' => '2 kotak'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'X-Ray SCP 1',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'Kursi Petugas X-Ray',
                'description' => null,
                'keterangan' => '4 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'Walk Through SCP 1',
                'description' => null,
                'keterangan' => '3 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'FIDS',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'CCTV',
                'description' => null,
                'keterangan' => '8 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'AC Central',
                'description' => null,
                'keterangan' => '9 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'AC Standing',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'Monitor Check In Counter',
                'description' => null,
                'keterangan' => '20 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'Meja dan Kursi Check In Counter',
                'description' => null,
                'keterangan' => '20 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'Conveyor Belt Label',
                'description' => null,
                'keterangan' => '18 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'Conveyor Belt Check In',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'Tempat Sampah',
                'description' => null,
                'keterangan' => '1 kotak'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'X-Ray SCP 2',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'Kursi Petugas X-Ray',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'Walk Through SCP 2',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'FIDS SCP 2',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'CCTV SCP 2',
                'description' => null,
                'keterangan' => '3 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'item_name' => 'AC Central SCP 2',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 3,
                'item_name' => 'Lift Disabilitas',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 3,
                'item_name' => 'Eskalator',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 3,
                'item_name' => 'Kursi',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 3,
                'item_name' => 'FIDS',
                'description' => null,
                'keterangan' => '2 unit (TV 1 unit)'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 3,
                'item_name' => 'CCTV',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 3,
                'item_name' => 'AC Central',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 3,
                'item_name' => 'Monitor BMKG',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 3,
                'item_name' => 'Monitor Gate',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 3,
                'item_name' => 'Meja Cek Boarding Pass',
                'description' => null,
                'keterangan' => '4 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 3,
                'item_name' => 'Kursi Cek Boarding Pass',
                'description' => null,
                'keterangan' => '4 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 3,
                'item_name' => 'Charging Station',
                'description' => null,
                'keterangan' => '4 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 3,
                'item_name' => 'Tempat Sampah',
                'description' => null,
                'keterangan' => '1 kotak'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 4,
                'item_name' => 'Kursi',
                'description' => null,
                'keterangan' => '40 seat'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 4,
                'item_name' => 'Meja',
                'description' => null,
                'keterangan' => '15 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 4,
                'item_name' => 'FIDS',
                'description' => null,
                'keterangan' => '1 unit (TV 1 unit)'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 4,
                'item_name' => 'CCTV',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 4,
                'item_name' => 'AC Central',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 4,
                'item_name' => 'AC Standing',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 4,
                'item_name' => 'Monitor Gate',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 4,
                'item_name' => 'Ruang Merokok',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 4,
                'item_name' => 'Kursi Ruang Merokok',
                'description' => null,
                'keterangan' => '6 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 4,
                'item_name' => 'Meja Ruang Merokok',
                'description' => null,
                'keterangan' => '6 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 4,
                'item_name' => 'Exhaust Fan Ruang Merokok',
                'description' => null,
                'keterangan' => '2 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 4,
                'item_name' => 'Air Purifier Ruang Merokok',
                'description' => null,
                'keterangan' => '3 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 4,
                'item_name' => 'Tempat Sampah Ruang Merokok',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 4,
                'item_name' => 'Asbak Ruang Merokok',
                'description' => null,
                'keterangan' => '3 buah'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 5,
                'item_name' => 'Kursi',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 5,
                'item_name' => 'FIDS',
                'description' => null,
                'keterangan' => '7 unit (TV 3 unit)'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 5,
                'item_name' => 'CCTV',
                'description' => null,
                'keterangan' => '14 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 5,
                'item_name' => 'AC Central',
                'description' => null,
                'keterangan' => '20 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 5,
                'item_name' => 'CCTV Garbarata',
                'description' => null,
                'keterangan' => '7 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 5,
                'item_name' => 'AC Garbarata',
                'description' => null,
                'keterangan' => '9 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 5,
                'item_name' => 'Monitor Gate',
                'description' => null,
                'keterangan' => '4 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 5,
                'item_name' => 'Meja Cek Boarding Pass',
                'description' => null,
                'keterangan' => '8 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 5,
                'item_name' => 'Kursi Cek Boarding Pass',
                'description' => null,
                'keterangan' => '8 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 5,
                'item_name' => 'Charging Station',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 5,
                'item_name' => 'Baby Stroller',
                'description' => null,
                'keterangan' => '4 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 5,
                'item_name' => 'Tempat Sampah',
                'description' => null,
                'keterangan' => '2 kotak'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 6,
                'item_name' => 'Trolley',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 6,
                'item_name' => 'FIDS',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 6,
                'item_name' => 'CCTV',
                'description' => null,
                'keterangan' => '9 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 6,
                'item_name' => 'AC Central',
                'description' => null,
                'keterangan' => '10 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 6,
                'item_name' => 'Lift Disabilitas',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 6,
                'item_name' => 'Eskalator',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 6,
                'item_name' => 'Monitor Baggage Claim',
                'description' => null,
                'keterangan' => '3 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 6,
                'item_name' => 'Conveyor Belt Bagasi',
                'description' => null,
                'keterangan' => '3 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 6,
                'item_name' => 'Kursi',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 6,
                'item_name' => 'Lift Barang',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 7,
                'item_name' => 'FIDS',
                'description' => null,
                'keterangan' => '1 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 7,
                'item_name' => 'CCTV',
                'description' => null,
                'keterangan' => '3 unit'
            ],
            [
                'category_id' => 1,
                'subcategory_id' => 7,
                'item_name' => 'Tempat Sampah',
                'description' => null,
                'keterangan' => '1 kotak'
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 8,
                'item_name' => 'Area Drop Zone',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 8,
                'item_name' => 'Area Lobby Keberangkatan',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 9,
                'item_name' => 'Area Check-In Counter',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 9,
                'item_name' => 'Area Conveyor Belt Label',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 9,
                'item_name' => 'Area SCP 1',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 9,
                'item_name' => 'Area SCP 2',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 9,
                'item_name' => 'Ruang Perkantoran Airlines',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 9,
                'item_name' => 'Ruang KKP',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 10,
                'item_name' => 'Area Ruang Tunggu',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 10,
                'item_name' => 'Pintu / Dinding Kaca',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 10,
                'item_name' => 'Musholla',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 10,
                'item_name' => 'Toilet',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 10,
                'item_name' => 'Eskalator',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 10,
                'item_name' => 'Tangga Manual',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 10,
                'item_name' => 'Lift Disabilitas',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 10,
                'item_name' => 'Ruang Disabilitas',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 10,
                'item_name' => 'Ruang Laktasi',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 10,
                'item_name' => 'Kantin / Tenant',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 11,
                'item_name' => 'Area Ruang VIP',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 11,
                'item_name' => 'Musholla',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 11,
                'item_name' => 'Ruang Merokok',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 11,
                'item_name' => 'Toilet',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 12,
                'item_name' => 'Area Ruang Tunggu',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 12,
                'item_name' => 'Pintu / Dinding Kaca',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 12,
                'item_name' => 'Musholla',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 12,
                'item_name' => 'Toilet',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 12,
                'item_name' => 'Tempat Bermain Anak',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 12,
                'item_name' => 'Ruang Disabilitas',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 12,
                'item_name' => 'Ruang Laktasi',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 12,
                'item_name' => 'Kantin / Tenant',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 13,
                'item_name' => 'Area Garbarata 1',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 13,
                'item_name' => 'Area Garbarata 2',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 13,
                'item_name' => 'Area Garbarata 3',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 13,
                'item_name' => 'Pintu / Dinding Kaca',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 14,
                'item_name' => 'Area Ruang Kedatangan',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 14,
                'item_name' => 'Pintu / Dinding Kaca',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 14,
                'item_name' => 'Area Conveyor',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 14,
                'item_name' => 'Eskalator',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 14,
                'item_name' => 'Tangga Manual',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 14,
                'item_name' => 'Lift Disabilitas',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 14,
                'item_name' => 'Toilet',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 14,
                'item_name' => 'Ruang Lost and Found',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 15,
                'item_name' => 'Area Pickup Zone',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 15,
                'item_name' => 'Area Lobby Kedatangan',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 15,
                'item_name' => 'Musholla',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 2,
                'subcategory_id' => 15,
                'item_name' => 'Toilet',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 3,
                'subcategory_id' => 16,
                'item_name' => 'Area Drop Zone Atas',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 3,
                'subcategory_id' => 16,
                'item_name' => 'Area Drop Zone Bawah',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 3,
                'subcategory_id' => 17,
                'item_name' => 'Area Pick-Up Zone Atas',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 3,
                'subcategory_id' => 17,
                'item_name' => 'Area Pick-Up Zone Bawah',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 3,
                'subcategory_id' => 18,
                'item_name' => 'Keberangkatan',
                'description' => null,
                'keterangan' => null
            ],
            [
                'category_id' => 3,
                'subcategory_id' => 18,
                'item_name' => 'Kedatangan',
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
