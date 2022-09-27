<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cv', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('title');
            $table->string('first_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('email')->unique();
            $table->string('phone', 15)->nullable();
            $table->string('avatar')->nullable();
            $table->string('address')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('skype')->nullable();
            $table->string('website')->nullable();
            $table->string('about_me', 512)->nullable();
            $table->string('technology_experience', 512)->nullable();

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
        Schema::dropIfExists('cv');
    }
};
