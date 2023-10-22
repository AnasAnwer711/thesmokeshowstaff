<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->nullable()->constrained();
            $table->foreignId('staff_id')->nullable()->constrained('users');
            $table->string('code');
            $table->enum('source', ['invited', 'received']);
            $table->enum('current_status', ['received','invited','cancelled','reinvited','accepted','rejected','booked','unbooked','completed','disputed','contacted']);
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
        Schema::dropIfExists('job_applicants');
    }
}
