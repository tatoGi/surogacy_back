<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop existing table if it exists
        Schema::dropIfExists('company_surrogate_favorites');

        Schema::create('company_surrogate_favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('surrogate_people_id');
            $table->timestamps();

            // Use a shorter name for the unique constraint
            $table->unique(['company_id', 'surrogate_people_id'], 'comp_surr_fav_unique');

            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('cascade');

            $table->foreign('surrogate_people_id')
                  ->references('id')
                  ->on('surrogate_people')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_surrogate_favorites');
    }
};
