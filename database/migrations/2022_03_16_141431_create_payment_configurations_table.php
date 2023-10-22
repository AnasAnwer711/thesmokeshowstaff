<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('publishable_key')->nullable();
            $table->string('secret_key')->nullable();
            $table->double('staff_signup_fee')->nullable();
            $table->string('staff_transaction_type')->nullable();
            $table->double('staff_transaction_fee')->nullable();
            $table->double('staff_minimum_transaction')->nullable();
            $table->double('host_signup_fee')->nullable();
            $table->string('host_transaction_type')->nullable();
            $table->double('host_transaction_fee')->nullable();
            $table->double('host_minimum_transaction')->nullable();
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
        Schema::dropIfExists('payment_configurations');
    }
}
