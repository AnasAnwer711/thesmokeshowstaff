<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionTypeToCancellationPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cancellation_policies', function (Blueprint $table) {
            $table->enum('transaction_type', ['percentage', 'flat'])->after('rule_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cancellation_policies', function (Blueprint $table) {
            $table->dropColumn('transaction_type');
        });
    }
}
