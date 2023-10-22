<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisputeBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispute_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_applicant_id')->constrained();
            $table->foreignId('dispute_title_id')->constrained();
            $table->foreignId('disputed_to')->constrained('users');
            $table->foreignId('disputed_by')->constrained('users');
            $table->longText('concern')->nullable();
            $table->enum('status',['open', 'resolved', 'no-issue'])->default('open');
            $table->longText('remarks')->nullable();
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
        Schema::dropIfExists('dispute_bookings');
    }
}
