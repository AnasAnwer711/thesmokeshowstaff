<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSubscriptionUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription_usages', function (Blueprint $table) {
            $table->dropColumn('subscribed_users');
            $table->foreignId('job_applicant_id')->after('subscription_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_usages', function (Blueprint $table) {
            $table->dropForeign(['job_applicant_id']);
            $table->dropColumn('job_applicant_id');
            $table->longText('subscribed_users');
        });
    }
}
