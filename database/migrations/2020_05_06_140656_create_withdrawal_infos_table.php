<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_infos', function (Blueprint $table) {
            $table->id();
            $table->string('wallet_id');
            $table->string('receiver');
            $table->string('account_number');
            $table->bigInteger('withdraw_amount');
            $table->string('status')->default('not approved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdrawal_infos');
    }
}
