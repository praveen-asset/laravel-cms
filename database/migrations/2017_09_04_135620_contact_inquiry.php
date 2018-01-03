<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContactInquiry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_inquiries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('email', 150);
            $table->string('phone', 20)->nullable();
            $table->string('subject', 200);
            $table->text('message');
            $table->string('user_ip', 100);
            $table->string('created_at', 40);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_inquiries');
    }
}
