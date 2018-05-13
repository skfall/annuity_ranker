<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osc_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->default(0);
            $table->integer('user_id')->default(0);
            $table->string('user_ip')->default(0);
            $table->integer('rank')->default(0);
            $table->string('review')->nullable();
            
            $table->boolean('block')->default(false);
            $table->dateTime('created')->nullable();
            $table->dateTime('modified')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('osc_reviews');
    }
}
