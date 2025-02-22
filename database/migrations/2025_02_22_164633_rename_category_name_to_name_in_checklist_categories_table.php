<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCategoryNameToNameInChecklistCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('checklist_categories', function (Blueprint $table)
        {
            // Rename the column
            $table->renameColumn('category_name', 'name');
        });
    }

    public function down()
    {
        Schema::table('checklist_categories', function (Blueprint $table)
        {
            // Reverse the renaming
            $table->renameColumn('name', 'category_name');
        });
    }
}
