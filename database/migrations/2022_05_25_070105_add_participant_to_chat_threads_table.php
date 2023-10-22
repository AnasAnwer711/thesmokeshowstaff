<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParticipantToChatThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chat_threads', function (Blueprint $table) {
            $table->foreignId('participant_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chat_threads', function (Blueprint $table) {
            $table->dropForeign(['participant_id']);
            $table->dropColumn('participant_id');
        });
    }
}
