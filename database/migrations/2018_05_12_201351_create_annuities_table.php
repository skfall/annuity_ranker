<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnuitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osc_annuities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('alias')->nullable();
            $table->integer('pos')->default(0);      
            $table->string('preview')->nullable();
            $table->string('background')->nullable();

            $table->integer('min_amount')->default(0);      
            $table->integer('max_amount')->default(10000000);      

            $table->string('col_1')->nullable();
            $table->string('col_2')->nullable();
            $table->string('col_3')->nullable();
            $table->string('col_4')->nullable();
            $table->string('col_5')->nullable();
            $table->string('col_6')->nullable();
            $table->string('col_7')->nullable();
        
            $table->boolean('is_video_bg')->default(false);
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
        Schema::dropIfExists('osc_annuities');
    }
}
