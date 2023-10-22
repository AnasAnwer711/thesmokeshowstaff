<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHelpfulKeysToStaffCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff_categories', function (Blueprint $table) {
            $table->foreignId('helpful_key_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_categories', function (Blueprint $table) {
            $table->dropForeign(['helpful_key_id']);
            $table->dropColumn('helpful_key_id');
        });
    }
}
