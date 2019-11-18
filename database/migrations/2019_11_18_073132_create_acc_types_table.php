<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('acc')->nullable();
            $table->timestamps();
        });

        Schema::table('parameter_products', function (Blueprint $table) {
            $table->unsignedBigInteger('acc_type_id')->nullable();

            $table->foreign('acc_type_id')->references('id')->on('acc_types');
        });

        Schema::table('cur_balances', function (Blueprint $table) {
            $table->unsignedBigInteger('acc_type_id')->nullable();

            $table->foreign('acc_type_id')->references('id')->on('acc_types');
        });

        Schema::table('account_mtds', function (Blueprint $table) {
            $table->unsignedBigInteger('acc_type_id')->nullable();

            $table->foreign('acc_type_id')->references('id')->on('acc_types');
        });

        Schema::table('account_ytds', function (Blueprint $table) {
            $table->unsignedBigInteger('acc_type_id')->nullable();

            $table->foreign('acc_type_id')->references('id')->on('acc_types');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('acc_type_id')->nullable();

            $table->foreign('acc_type_id')->references('id')->on('acc_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_types');
    }
}
