<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCancellationEnableToPaymentConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_configurations', function (Blueprint $table) {
            $table->boolean('host_cancellation')->default(0);
            $table->boolean('staff_cancellation')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_configurations', function (Blueprint $table) {
            $table->dropColumn(['host_cancellation', 'staff_cancellation']);
        });
    }
}
