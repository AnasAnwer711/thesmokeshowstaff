<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViewGetMessagesCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS `message_count`");
        DB::statement("CREATE VIEW message_count AS SELECT 
                ct.id,
                ct.initiated_by,
                ct.participant_id,
            COUNT(DISTINCT um.id) AS total 
            FROM
                chat_threads ct 
            JOIN user_messages um 
                ON (ct.id = um.chat_id) 
            GROUP BY ct.id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW message_count");
    }
}
