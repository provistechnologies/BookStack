<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnsScreenshotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('screenshots', function (Blueprint $table) {
            if (Schema::hasColumn('screenshots', 'character_count')) {
                $table->renameColumn('character_count', 'key_count');
            }
            if (Schema::hasColumn('screenshots', 'time')) {
                $table->renameColumn('time', 'screenshot_time');
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
            if (Schema::hasColumn('screenshots', 'key_count')) {
                $table->renameColumn('key_count', 'character_count');
            }
            if (Schema::hasColumn('screenshots', 'screenshot_time')) {
                $table->renameColumn('screenshot_time', 'time');
            }
        });
    }
}
