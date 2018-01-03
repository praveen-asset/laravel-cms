<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->increments('type_id');
            $table->integer('user_id')->unsigned();
            $table->enum('user_type', ['1', '2'])->default('1')->comment= "'1- Member','2 - Admin' - Edit this field to get more user types";

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        DB::table('user_types')->insert(
            array(
                'user_id'           => 1,
                'user_type'         => '2'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_types');
    }
}
