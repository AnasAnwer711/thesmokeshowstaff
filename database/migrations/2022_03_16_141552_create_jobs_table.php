<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('staff_category_id')->constrained();
            $table->foreignId('country_id')->constrained('nationalities');
            $table->foreignId('address_id')->constrained();
            $table->foreignId('travel_allowance_id')->nullable()->constrained();
            $table->string('job_title');
            $table->text('title');
            $table->string('description')->nullable();
            $table->datetime('date');
            $table->string('gender');
            $table->string('location');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->double('duration');
            $table->string('dress_code');
            $table->double('pay_rate');
            $table->enum('pay_type', ['per_hour', 'per_party']);
            // $table->integer('travel_allowance_id');
            $table->integer('no_of_positions');
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('jobs');
    }
}
