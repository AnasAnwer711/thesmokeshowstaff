<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDefaultSkillPhotoToSkillPhotoMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('skill_photo_mappings', function (Blueprint $table) {
            $table->tinyInteger('is_default_skill_photo')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('skill_photo_mappings', function (Blueprint $table) {
            $table->dropColumn('is_default_skill_photo');
        });
    }
}
