<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('youtube')->nullable();
            $table->foreignId('nationality_id')->constrained('nationalities');
            $table->foreignId('address_id')->nullable()->constrained('addresses');
            $table->foreignId('build_type_id')->nullable()->constrained();
            $table->enum('english_level', ['beginner', 'intermediate', 'advanced'])->nullable();
            $table->boolean('rsa_qualified')->default(0);
            $table->boolean('rcg_qualified')->default(0);
            $table->boolean('security_qualified')->default(0);
            $table->boolean('silver_service_qualified')->default(0);
            $table->boolean('email_notified')->default(0);
            $table->boolean('sms_notified')->default(0);
            $table->boolean('is_active')->default(1);
            $table->enum('status', ['pending', 'approved', 'rejected', 'blocked'])->default('approved');
            $table->longText('resume')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
