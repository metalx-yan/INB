<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountYtdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_ytds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('position_product');
            $table->string('work')->nullable();
            // $table->string('acc_type');
            $table->integer('total_acc');
            $table->double('start')->nullable();
            $table->double('end')->nullable();
            $table->timestamps();
        });

        Schema::table('account_ytds', function (Blueprint $table) {
            $table->unsignedBigInteger('region_id')->nullable();
    
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
        Schema::dropIfExists('account_ytds');
    }
}
