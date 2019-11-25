<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('number');
            $table->bigInteger('cif_key');
            $table->date('cif_created_at');
            $table->date('account_open');
            $table->float('average', 12,2);
            $table->float('current_balance', 12,2);
            $table->string('currency');
            $table->date('birth_date');
            $table->string('handphone');
            $table->text('adrress');
            $table->string('company');
            $table->string('occupation');
            $table->string('status');
            $table->decimal('monthly_income', 10, 2);
            $table->boolean('gender');
            $table->string('work_phone');
            $table->string('home_phone');
            $table->string('workplace_name');
            $table->string('workplace_address');
            $table->string('email');
            $table->integer('identity');
            $table->string('place_of_birth');
            $table->timestamps();
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('branch_id')->references('id')->on('branches');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
