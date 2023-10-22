<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterJobApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_applicants', function (Blueprint $table) {
            $table->dropColumn(['payment_mode', 'fee']);
            $table->enum('host_payment_mode', ['card', 'subscribe'])->nullable();
            $table->double('host_fee')->default(0);
            $table->integer('job_actual_hours')->nullable();
            $table->integer('job_extended_hours')->nullable();
            $table->enum('job_pay_type', ['per_hour', 'per_party'])->nullable();
            $table->double('job_pay_rate')->nullable();
            $table->double('job_pay')->default(0);

            
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
            $table->enum('payment_mode', ['card', 'subscribe'])->nullable();
            $table->double('fee')->nullable();
        });
    }
}
