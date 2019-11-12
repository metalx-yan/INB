<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('regional_savings', function (Blueprint $table) {
            $table->unsignedBigInteger('group_product_id')->nullable();

            $table->foreign('group_product_id')->references('id')->on('group_products');
        });

        Schema::table('group_products', function (Blueprint $table) {
            $table->unsignedBigInteger('type_product_id')->nullable();

            $table->foreign('type_product_id')->references('id')->on('type_products');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('group_product_id')->nullable();
    
            $table->foreign('group_product_id')->references('id')->on('group_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_products');
    }
}
