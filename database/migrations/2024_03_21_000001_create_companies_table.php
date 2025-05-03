<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('email');
            $table->timestamps();
        });

        Schema::create('company_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('country');
            $table->unique(['company_id', 'locale']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_translations');
        Schema::dropIfExists('companies');
    }
};
