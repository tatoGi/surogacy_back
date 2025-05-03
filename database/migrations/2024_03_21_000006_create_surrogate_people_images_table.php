<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('surrogate_people_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surrogate_people_id');
            $table->string('image_path');
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->foreign('surrogate_people_id')
                  ->references('id')
                  ->on('surrogate_people')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('surrogate_people_images');
    }
};
