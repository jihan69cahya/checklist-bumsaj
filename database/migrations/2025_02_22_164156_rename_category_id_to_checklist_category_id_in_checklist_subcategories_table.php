<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCategoryIdToChecklistCategoryIdInChecklistSubcategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('checklist_subcategories', function (Blueprint $table)
        {
            $table->renameColumn('category_id', 'checklist_category_id');
        });
    }

    public function down()
    {
        Schema::table('checklist_subcategories', function (Blueprint $table)
        {
            $table->renameColumn('checklist_category_id', 'category_id');
        });
    }
}
