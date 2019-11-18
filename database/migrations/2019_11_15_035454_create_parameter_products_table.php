<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParameterProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameter_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->string('acc_type')->nullable();
            $table->string('group_product_first');
            $table->string('group_product_second');
            $table->string('group_product_third');
            $table->timestamps();
        });

        Schema::table('parameter_products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('type_product_id')->nullable();
    
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('type_product_id')->references('id')->on('type_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parameter_products');
    }
}
