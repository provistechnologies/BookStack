<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'designation')) {
                $table->text('designation')->after('email');
            }
            if (!Schema::hasColumn('users', 'joining_date')) {
                $table->date('joining_date')->after('designation');
            }
            if (!Schema::hasColumn('users', 'birth_date')) {
                $table->date('birth_date')->after('joining_date');
            }
            if (!Schema::hasColumn('users', 'qualification')) {
                $table->string('qualification')->after('birth_date');
            }
            if (!Schema::hasColumn('users', 'contact')) {
                $table->string('contact')->after('qualification');
            }
            if (!Schema::hasColumn('users', 'present_address')) {
                $table->text('present_address')->after('contact');
            }
            if (!Schema::hasColumn('users', 'permanent_address')) {
                $table->text('permanent_address')->after('present_address');
            }
            if (!Schema::hasColumn('users', 'first_ref_name')) {
                $table->string('first_ref_name')->after('permanent_address');
            }
            if (!Schema::hasColumn('users', 'first_ref_contact')) {
                $table->string('first_ref_contact')->after('first_ref_name');
            }
            if (!Schema::hasColumn('users', 'second_ref_name')) {
                $table->string('second_ref_name')->after('first_ref_contact');
            }
            if (!Schema::hasColumn('users', 'second_ref_contact')) {
                $table->string('second_ref_contact')->after('second_ref_name');
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
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'designation')) {
                $table->dropColumn('designation');
            }
            if (Schema::hasColumn('users', 'joining_date')) {
                $table->dropColumn('joining_date');
            }
            if (Schema::hasColumn('users', 'birth_date')) {
                $table->dropColumn('birth_date');
            }
            if (Schema::hasColumn('users', 'qualification')) {
                $table->dropColumn('qualification');
            }
            if (Schema::hasColumn('users', 'contact')) {
                $table->dropColumn('contact');
            }
            if (Schema::hasColumn('users', 'present_address')) {
                $table->dropColumn('present_address');
            }
            if (Schema::hasColumn('users', 'permanent_address')) {
                $table->dropColumn('permanent_address');
            }
            if (Schema::hasColumn('users', 'first_ref_name')) {
                $table->dropColumn('first_ref_name');
            }
            if (Schema::hasColumn('users', 'first_ref_contact')) {
                $table->dropColumn('first_ref_contact');
            }
            if (Schema::hasColumn('users', 'second_ref_name')) {
                $table->dropColumn('second_ref_name');
            }
            if (Schema::hasColumn('users', 'second_ref_contact')) {
                $table->dropColumn('second_ref_contact');
            }
        });
    }
}