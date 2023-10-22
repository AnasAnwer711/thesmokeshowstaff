<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobApplicantTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_applicant_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_applicant_id')->constrained();
            $table->enum('status', ['received','invited','cancelled','reinvited','accepted','rejected','booked','unbooked','completed','disputed','contacted']);
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
        Schema::dropIfExists('job_applicant_transactions');
    }
}
