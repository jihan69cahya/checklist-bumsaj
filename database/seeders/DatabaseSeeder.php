<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Truncate all tables
        $tables = [
            'periods',
            'checklist_categories',
            'entry_values',
            'checklist_subcategories',
            'checklist_items',
            'users', // Add other tables if needed
        ];

        foreach ($tables as $table)
        {
            DB::table($table)->truncate();
        }

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        // Run the seeders
        $this->call([
            PeriodSeeder::class,
            ChecklistCategorySeeder::class,
            EntryValuesSeeder::class,
            ChecklistSubcategorySeeder::class,
            ChecklistItemSeeder::class,
            UserSeeder::class
        ]);
    }
}
