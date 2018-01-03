<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug', 100);
            $table->string('title', 250);
            $table->text('content');
            $table->string('meta_title', 150)->nullable();
            $table->text('meta_tags')->nullable();
            $table->text('meta_description')->nullable();
            $table->enum('status', ['0', '1'])->default('1')->comment = "'0 - Inactive','1 - Active'";
            $table->string('created_at', 40);
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
        Schema::dropIfExists('cms');
    }
}
