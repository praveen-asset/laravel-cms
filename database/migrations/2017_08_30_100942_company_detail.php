<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompanyDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_details', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['1', '2', '3', '4'])->comment = "'1 - Company Name','2 - Address','3 - Phone','4 - Email'";
            $table->string('label');
            $table->string('value');
            $table->tinyInteger('default')->default('1')->comment = "'1 = yes', '0 = no'";
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
        Schema::dropIfExists('company_details');
    }
}
