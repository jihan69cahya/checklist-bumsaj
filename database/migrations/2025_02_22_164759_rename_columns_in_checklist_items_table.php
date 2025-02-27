<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnsInChecklistItemsTable extends Migration
{
    public function up()
    {
        Schema::table('checklist_items', function (Blueprint $table)
        {
            // Rename item_name to name
            $table->renameColumn('item_name', 'name');

            // Rename subcategory_id to checklist_subcategory_id
            $table->renameColumn('subcategory_id', 'checklist_subcategory_id');
        });
    }

    public function down()
    {
        Schema::table('checklist_items', function (Blueprint $table)
        {
            // Reverse the renaming
            $table->renameColumn('name', 'item_name');
            $table->renameColumn('checklist_subcategory_id', 'subcategory_id');
        });
    }
}
