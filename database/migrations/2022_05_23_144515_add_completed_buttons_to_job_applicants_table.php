<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompletedButtonsToJobApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_applicants', function (Blueprint $table) {
            $table->boolean('completed_by_host')->default(0);
            $table->boolean('completed_by_staff')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_applicants', function (Blueprint $table) {
            $table->dropColumn(['completed_by_host', 'completed_by_staff']);
        });
    }
}
