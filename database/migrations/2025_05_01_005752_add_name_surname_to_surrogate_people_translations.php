<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameSurnameToSurrogatePeopleTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surrogate_people_translations', function (Blueprint $table) {
            $table->string('name')->after('title');
            $table->string('surname')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surrogate_people_translations', function (Blueprint $table) {
            $table->dropColumn(['name', 'surname']);
        });
    }
}
