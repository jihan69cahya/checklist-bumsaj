<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('checklist_entries', function (Blueprint $table)
        {
            $table->id();

            // Kolom untuk menghubungkan dengan tabel lain
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('checklist_categories')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('checklist_items')->onDelete('cascade');
            $table->foreignId('period_id')->constrained('period')->onDelete('cascade');

            // Mengubah kolom status menjadi foreign key yang merujuk ke tabel entry_values
            $table->foreignId('entry_value_id')->constrained('entry_values')->onDelete('cascade');

            // Tanggal dan waktu entri
            $table->date('entry_date');
            $table->time('entry_time');

            // Timestamp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_entries');
    }
};
