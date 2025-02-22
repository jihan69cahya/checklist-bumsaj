<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateChecklistEntriesTable extends Migration
{
    public function up()
    {
        Schema::table('checklist_entries', function (Blueprint $table)
        {
            // Drop foreign key constraint for item_id (if it exists)
            if (Schema::hasColumn('checklist_entries', 'item_id'))
            {
                $table->dropForeign(['item_id']);
            }

            // Rename item_id to checklist_item_id
            if (Schema::hasColumn('checklist_entries', 'item_id'))
            {
                $table->renameColumn('item_id', 'checklist_item_id');
            }

            // Re-add foreign key constraint for checklist_item_id
            $table->foreign('checklist_item_id')
                ->references('id')
                ->on('checklist_items')
                ->onDelete('cascade');

            // Drop foreign key constraint for category_id (if it exists)
            if (Schema::hasColumn('checklist_entries', 'category_id'))
            {
                $table->dropForeign(['category_id']);
            }

            // Drop the category_id column
            if (Schema::hasColumn('checklist_entries', 'category_id'))
            {
                $table->dropColumn('category_id');
            }
        });
    }

    public function down()
    {
        Schema::table('checklist_entries', function (Blueprint $table)
        {
            // Re-add the category_id column
            $table->unsignedBigInteger('category_id')->nullable(); // Adjust the column definition as needed

            // Re-add foreign key constraint for category_id (if it existed)
            $table->foreign('category_id')
                ->references('id')
                ->on('checklist_categories')
                ->onDelete('cascade');

            // Drop foreign key constraint for checklist_item_id
            if (Schema::hasColumn('checklist_entries', 'checklist_item_id'))
            {
                $table->dropForeign(['checklist_item_id']);
            }

            // Reverse the renaming
            if (Schema::hasColumn('checklist_entries', 'checklist_item_id'))
            {
                $table->renameColumn('checklist_item_id', 'item_id');
            }

            // Re-add foreign key constraint for item_id
            $table->foreign('item_id')
                ->references('id')
                ->on('checklist_items')
                ->onDelete('cascade');
        });
    }
}
