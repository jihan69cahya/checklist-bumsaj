<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCategoryIdToChecklistCategoryIdInChecklistItemsTable extends Migration
{
    public function up()
    {
        Schema::table('checklist_items', function (Blueprint $table)
        {
            // Rename the column
            $table->renameColumn('category_id', 'checklist_category_id');
        });
    }

    public function down()
    {
        Schema::table('checklist_items', function (Blueprint $table)
        {
            // Reverse the renaming
            $table->renameColumn('checklist_category_id', 'category_id');
        });
    }
}
