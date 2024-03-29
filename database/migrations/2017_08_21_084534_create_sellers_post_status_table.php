<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellersPostStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //seller_post_statuses
    public function up()
    {
        Schema::create('seller_post_statuses', function (Blueprint $table){
            $table->increments('id');
            $table->string('slug');
            $table->string('name');
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
        Schema::dropIfExists('seller_post_statuses');
    }
}
