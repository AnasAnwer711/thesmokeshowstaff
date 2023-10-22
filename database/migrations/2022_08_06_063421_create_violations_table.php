<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViolationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('user_message_id')->constrained();
            $table->foreignId('chat_thread_id')->constrained();
            $table->enum('status', ['pending', 'declined', 'completed'])->default('pending');
            $table->enum('action', ['none', 'legal', 'illegal'])->default('none');
            $table->boolean('is_penalized')->default(false);
            $table->double('penalized_amount')->default(0);
            $table->boolean('is_blocked')->default(false);
            $table->longText('matched_string')->nullable();
            $table->longText('notes')->nullable();
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
        Schema::dropIfExists('violations');
    }
}
