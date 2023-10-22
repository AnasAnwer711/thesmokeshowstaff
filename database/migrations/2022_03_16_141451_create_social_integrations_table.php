<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialIntegrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_integrations', function (Blueprint $table) {
            $table->boolean('enable_facebook')->default(0);
            $table->string('facebook_app_id');
            $table->string('facebook_app_secret');
            $table->boolean('enable_google')->default(0);
            $table->string('google_client_id');
            $table->string('google_client_secret');
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
        Schema::dropIfExists('social_integrations');
    }
}
