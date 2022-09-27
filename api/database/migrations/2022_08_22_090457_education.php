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
        Schema::create('education', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('institution_name');
            $table->date('period_from')->nullable();
            $table->date('period_to')->nullable();
            $table->string('faculty')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->string('summary', 512)->nullable();
            $table->integer('cv_id')->unsigned();
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
        Schema::dropIfExists('education');
    }
};
