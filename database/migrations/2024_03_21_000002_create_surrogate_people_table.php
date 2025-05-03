<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop existing tables if they exist
        Schema::dropIfExists('surrogate_people_translations');
        Schema::dropIfExists('surrogate_people');

        Schema::create('surrogate_people', function (Blueprint $table) {
            $table->id();
            $table->integer('age');
            $table->decimal('height', 5, 2);
            $table->decimal('weight', 5, 2);
            $table->string('blood_type');
            $table->timestamps();
        });

        Schema::create('surrogate_people_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surrogate_people_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->string('nationality');
            $table->string('hair_color');
            $table->string('eye_color');
            $table->string('skin_complexion');
            $table->string('education');
            $table->string('marital_status');
            $table->string('race');
            $table->text('donation_experience');
            $table->unique(['surrogate_people_id', 'locale']);

            $table->foreign('surrogate_people_id')
                  ->references('id')
                  ->on('surrogate_people')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('surrogate_people_translations');
        Schema::dropIfExists('surrogate_people');
    }
};
