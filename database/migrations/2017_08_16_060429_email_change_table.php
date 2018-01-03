<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmailChangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_changes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 60);
            $table->rememberToken();
            $table->integer('user_id')->unsigned();
            $table->enum('status', ['0', '1'])->default('0')->comment = "0 - Not Verified', 1 - Verified";
            $table->string('created_at', 40);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_changes');
    }
}
