<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osc_companies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('alias')->nullable();
            $table->boolean('block')->default(false);

            $table->string('td_field_15_r1')->nullable();
            $table->string('td_field_15_r2')->nullable();
            $table->string('td_field_15_r3')->nullable();
            $table->string('td_field_15_r4')->nullable();
            $table->string('td_field_14')->nullable();
            $table->string('logo')->nullable();
            $table->string('td_field_11')->nullable();

            $table->integer('min_amount')->default(0);      
            $table->integer('max_amount')->default(10000000);  
            
            $table->float('percent')->default(0);
            $table->boolean('percent_plus')->default(false);
            
            $table->boolean('td_field_29_plus')->default(false);
            $table->boolean('td_field_27_plus')->default(false);

            $table->string('td_field_30')->nullable();
            $table->string('td_field_31')->nullable();
            $table->string('td_field_16')->nullable();
            $table->string('td_field_10_r1')->nullable();
            $table->string('td_field_10_r2')->nullable();
            $table->string('td_field_10_r3')->nullable();
            $table->string('td_field_10_r4')->nullable();
            $table->string('td_field_9_r1')->nullable();
            $table->string('td_field_9_r2')->nullable();
            $table->string('td_field_8_r1')->nullable();
            $table->string('td_field_8_r2')->nullable();
            $table->string('td_field_8_r3')->nullable();
            $table->string('td_field_8_r4')->nullable();
            $table->string('td_field_7_r1')->nullable();
            $table->string('td_field_7_r2')->nullable();
            $table->string('td_field_7_r3')->nullable();
            $table->string('td_field_7_r4')->nullable();
 
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
        Schema::dropIfExists('osc_companies');
    }
}
