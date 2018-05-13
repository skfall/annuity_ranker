<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osc_rates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            
            $table->integer('annuity_id')->default(0);
            $table->integer('company_id')->default(0);
            $table->integer('age')->default(0);

            $table->float('rate1')->default(0);
            $table->float('special_rate1')->default(0);

            $table->float('rate2')->default(0);
            $table->float('special_rate2')->default(0);

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
        Schema::dropIfExists('osc_rates');
    }
}
