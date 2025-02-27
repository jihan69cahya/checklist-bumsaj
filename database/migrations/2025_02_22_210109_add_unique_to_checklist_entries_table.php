<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueToChecklistEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checklist_entries', function (Blueprint $table)
        {
            $table->unique(['checklist_item_id', 'period_id', 'entry_date'], 'unique_entry_per_item_period_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checklist_entries', function (Blueprint $table)
        {
            $table->dropUnique('unique_entry_per_item_period_date');
        });
    }
}
