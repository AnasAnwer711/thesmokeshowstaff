<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangesInJobLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_logs', function (Blueprint $table) {
            $table->dropForeign(['initiated_by']);
            $table->dropColumn(['initiated_by', 'job_status']);
            $table->enum('status', ['open', 'started', 'elapsed', 'closed'])->default('open')->after('job_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_logs', function (Blueprint $table) {
            $table->foreignId('initiated_by')->constrained('users');
            $table->string('job_status');
            
        });
    }
}
