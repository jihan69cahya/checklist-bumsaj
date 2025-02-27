<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSubcategoryNameToNameInChecklistSubcategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('checklist_subcategories', function (Blueprint $table)
        {
            // Rename the column
            $table->renameColumn('subcategory_name', 'name');
        });
    }

    public function down()
    {
        Schema::table('checklist_subcategories', function (Blueprint $table)
        {
            // Reverse the renaming
            $table->renameColumn('name', 'subcategory_name');
        });
    }
}
