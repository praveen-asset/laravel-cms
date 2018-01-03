<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 60);
            $table->string('last_name', 60)->nullable();
            $table->text('profile_picture')->nullable();
            $table->enum('gender', ['m', 'f', 'o', 'u'])->default('u')->comment = "'m - Male','f - Female','o - Other','u - Unspecified'";
            $table->date('user_dob')->nullable();
            $table->string('phone_code', 10)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('email', 100)->unique();
            $table->string('username', 20)->nullable();
            $table->string('password');
            $table->integer('city_id')->nullable();
            $table->text('address_one')->nullable();
            $table->text('address_two')->nullable();
            $table->string('zip', 20)->nullable();
            $table->enum('status', ['0', '1', '2', '3'])->default('0')->comment = "'0 - Pending','1 - Active','2 - Inactive','3 - Blocked'";
            $table->rememberToken();
            $table->string('user_last_login', 40)->default('0');
            $table->string('created_at', 40);
            $table->string('updated_at', 40);
        });


        DB::table('users')->insert(
            array(
                'first_name'        => 'Admin',
                'email'             => 'hello@example.com',
                'password'          => bcrypt('Admin@123'),
                'status'            => '1',
                'created_at'        => time(),
                'updated_at'        => time()
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
        Schema::dropIfExists('users');
    }
}
