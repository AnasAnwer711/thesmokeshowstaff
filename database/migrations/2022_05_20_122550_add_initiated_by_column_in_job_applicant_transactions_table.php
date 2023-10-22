<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInitiatedByColumnInJobApplicantTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_applicant_transactions', function (Blueprint $table) {
            $table->foreignId('initiated_by')->nullable()->after('job_applicant_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_applicant_transactions', function (Blueprint $table) {
            $table->dropForeign(['initiated_by']);
            $table->dropColumn(['initiated_by']);
        });
    }
}
