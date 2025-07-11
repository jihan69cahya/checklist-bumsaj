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
        Schema::table('checklist_entries', function (Blueprint $table) {
            $table->tinyInteger('is_validate')->default(0)->after('entry_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checklist_entries', function (Blueprint $table) {
            $table->dropColumn('is_validate');
        });
    }
};
