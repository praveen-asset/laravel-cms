<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SocialNetworks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_networks', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('order_by')->default(1);
            $table->string('social_type', 50);
            $table->text('social_link')->nullable();
            $table->tinyInteger('show_on')->default(1);
            $table->string('updated_at', 40);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_networks');
    }
}
