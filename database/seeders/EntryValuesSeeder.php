<?php

namespace Database\Seeders;

use App\Models\EntryValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntryValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EntryValue::create([
            'checklist_category_id' => 1,
            'value_code' => 'B',
            'value_description' => 'Berfungsi',
        ]);
        EntryValue::create([
            'checklist_category_id' => 1,
            'value_code' => 'RK',
            'value_description' => 'Rusak',
        ]);
        EntryValue::create([
            'checklist_category_id' => 2,
            'value_code' => 'B',
            'value_description' => 'Bersih',
        ]);
        EntryValue::create([
            'checklist_category_id' => 2,
            'value_code' => 'KB',
            'value_description' => 'Kurang Bersih',
        ]);
        EntryValue::create([
            'checklist_category_id' => 2,
            'value_code' => 'K',
            'value_description' => 'Kotor',
        ]);
        EntryValue::create([
            'checklist_category_id' => 3,
            'value_code' => 'P',
            'value_description' => 'Padat',
        ]);
        EntryValue::create([
            'checklist_category_id' => 3,
            'value_code' => 'L',
            'value_description' => 'Lancar',
        ]);
    }
}
