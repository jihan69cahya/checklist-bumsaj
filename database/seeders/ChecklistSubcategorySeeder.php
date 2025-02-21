<?php

namespace Database\Seeders;

use App\Models\ChecklistSubcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChecklistSubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subcategories = [
            1 => [
                'Lobby Keberangkatan',
                'Ruang Check-In Counter',
                'Ruang Tunggu Bawah (Gate 2 & Gate 3)',
                'Ruang Tunggu VIP (Gate 1)',
                'Ruang Tunggu Atas (Gate 4, 5, 6, 7)',
                'Ruang Kedatangan',
                'Lobby Kedatangan'
            ],
            2 => [
                'Lobby Keberangkatan',
                'Ruang Check-In Counter',
                'Ruang Tunggu Bawah (Gate 2 & Gate 3)',
                'Ruang Tunggu VIP (Gate 1)',
                'Ruang Tunggu Atas (Gate 4, 5, 6, 7)',
                'Garbarata',
                'Ruang Kedatangan',
                'Lobby Kedatangan'
            ],
            3 => [
                'Keberangkatan',
                'Kedatangan',
                'Parkir VIP'
            ]
        ];

        foreach ($subcategories as $category_id => $subcategories_list)
        {
            foreach ($subcategories_list as $subcategory_name)
            {
                ChecklistSubcategory::create([
                    'category_id' => $category_id,
                    'subcategory_name' => $subcategory_name,
                ]);
            }
        }
    }
}
