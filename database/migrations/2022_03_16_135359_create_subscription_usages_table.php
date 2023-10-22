<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained();
            $table->integer('limit_used');
            $table->integer('date_utlized');
            $table->longText('subscribed_users');
            $table->enum('status',['active', 'completed', 'revoke']);
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
        Schema::dropIfExists('subscription_usages');
    }
}
