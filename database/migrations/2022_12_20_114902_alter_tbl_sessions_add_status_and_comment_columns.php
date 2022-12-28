<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTblSessionsAddStatusAndCommentColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tbl_sessions', 'status')) {
            Schema::table('tbl_sessions', function ($table) {
                $table->string('status')->after('user_id')->nullable();
            });
        }

        if (!Schema::hasColumn('tbl_sessions', 'comments')) {
            Schema::table('tbl_sessions', function ($table) {
                $table->longText('comments')->after('user_id')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('tbl_sessions', 'status')) {
            Schema::table('tbl_sessions', function ($table) {
                $table->dropColumn('status');
            });
        }

        if (Schema::hasColumn('tbl_sessions', 'comments')) {
            Schema::table('tbl_sessions', function ($table) {
                $table->dropColumn('comments');
            });
        }
    }
}
