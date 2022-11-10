<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id')->index();
            $table->string('email');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->date('date');
            $table->text('list');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_sessions');
    }
}
