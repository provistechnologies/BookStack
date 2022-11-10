<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClomnScreenshotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('screenshots', function (Blueprint $table) {
            if (!Schema::hasColumn('screenshots', 'session_id')) {
                $table->foreignId('session_id')->after('id');
            }
            if (!Schema::hasColumn('screenshots', 'screenshot')) {
                $table->text('screenshot')->after('session_id');
            }
            if (!Schema::hasColumn('screenshots', 'character_count')) {
                $table->string('character_count')->after('screenshot');
            }
            if (!Schema::hasColumn('screenshots', 'time')) {
                $table->timestamp('time')->after('character_count');
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
        Schema::table('screenshots', function (Blueprint $table) {
            if (Schema::hasColumn('screenshots', 'session_id')) {
                $table->dropColumn('session_id');
            }
            if (Schema::hasColumn('screenshots', 'screenshot')) {
                $table->dropColumn('screenshot');
            }
            if (Schema::hasColumn('screenshots', 'character_count')) {
                $table->dropColumn('character_count');
            }
            if (Schema::hasColumn('screenshots', 'time')) {
                $table->dropColumn('time');
            }
        });
    }
}
