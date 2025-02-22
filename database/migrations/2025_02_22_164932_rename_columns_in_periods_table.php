<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnsInPeriodsTable extends Migration
{
    public function up()
    {
        Schema::table('periods', function (Blueprint $table)
        {
            // Rename period_start_time to start_time
            $table->renameColumn('period_start_time', 'start_time');

            // Rename period_end_time to end_time
            $table->renameColumn('period_end_time', 'end_time');

            // Rename period_label to label
            $table->renameColumn('period_label', 'label');
        });
    }

    public function down()
    {
        Schema::table('periods', function (Blueprint $table)
        {
            // Reverse the renaming
            $table->renameColumn('start_time', 'period_start_time');
            $table->renameColumn('end_time', 'period_end_time');
            $table->renameColumn('label', 'period_label');
        });
    }
}
