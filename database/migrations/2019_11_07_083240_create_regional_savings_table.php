<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionalSavingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regional_savings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->integer('number_account');
            $table->double('balance');
            $table->timestamps();
        });

        Schema::table('regional_savings', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('region_id')->references('id')->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regional_savings');
    }
}
