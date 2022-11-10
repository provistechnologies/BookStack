<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnsTblSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_sessions', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_sessions', 'start_time')) {
                $table->renameColumn('start_time', 'session_start_time');
            }
            if (Schema::hasColumn('tbl_sessions', 'end_time')) {
                $table->renameColumn('end_time', 'session_end_time');
            }
            if (Schema::hasColumn('tbl_sessions', 'date')) {
                $table->renameColumn('date', 'session_date');
            }
            if (Schema::hasColumn('tbl_sessions', 'email')) {
                $table->dropColumn('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_sessions', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_sessions', 'session_start_time')) {
                $table->renameColumn('session_start_time', 'start_time');
            }
            if (Schema::hasColumn('tbl_sessions', 'session_end_time')) {
                $table->renameColumn('session_end_time', 'end_time');
            }
            if (Schema::hasColumn('tbl_sessions', 'session_date')) {
                $table->renameColumn('session_date', 'date');
            }
            if (!Schema::hasColumn('tbl_sessions', 'email')) {
                $table->text('email');
            }
        });
    }
}
