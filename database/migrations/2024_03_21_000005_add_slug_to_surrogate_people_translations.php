<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('surrogate_people_translations', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('surrogate_people_id');
        });
    }

    public function down()
    {
        Schema::table('surrogate_people_translations', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
