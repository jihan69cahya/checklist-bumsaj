<?php

namespace Database\Seeders;

use App\Models\ChecklistCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChecklistCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChecklistCategory::create([
            'name' => 'Fasilitas Gedung Terminal',
            'description' => 'Kategori untuk mengecek fasilitas yang ada di gedung terminal'
        ]);

        ChecklistCategory::create([
            'name' => 'Kebersihan Gedung Terminal',
            'description' => 'Kategori untuk mengecek kebersihan gedung terminal'
        ]);

        ChecklistCategory::create([
            'name' => 'Kondisi Area Curbside',
            'description' => 'Kategori untuk mengecek kondisi area curbside di sekitar terminal'
        ]);
    }
}
