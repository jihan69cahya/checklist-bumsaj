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
        Schema::create('entry_values', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('category_id')->constrained('checklist_categories')->onDelete('cascade');
            $table->string('value_code');  // Kode nilai entri, seperti B, RK, L, dll
            $table->string('value_description');  // Deskripsi dari nilai entri (e.g., 'Bersih', 'Rusak')
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entry_values');
    }
};
