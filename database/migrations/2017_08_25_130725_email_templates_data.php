<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmailTemplatesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('email_templates')->insert(
            array(
                'slug'          => 'user-join-mail',
                'subject'       => '{{app_name}} has invited you to join!',
                'text_tag'      => 'first_name,last_name,join_url',
                'email_body'    => File::get(public_path('email_migrations/user-join-mail.html')),
                'created_at'    => time()
            )
        );

        DB::table('email_templates')->insert(
            array(
                'slug'          => 'user-welcome-mail',
                'subject'       => 'Welcome to {{app_name}}!',
                'text_tag'      => 'first_name,last_name,verify_url, confirmation_code',
                'email_body'    => File::get(public_path('email_migrations/user-welcome-mail.html')),
                'created_at'    => time()
            )
        );

        DB::table('email_templates')->insert(
            array(
                'slug'          => 'user-verification-mail',
                'subject'       => 'Verify your email address!',
                'text_tag'      => 'first_name,last_name,verify_url, confirmation_code',
                'email_body'    => File::get(public_path('email_migrations/user-verification-mail.html')),
                'created_at'    => time()
            )
        );

        DB::table('email_templates')->insert(
            array(
                'slug'          => 'user-resetpassword-mail',
                'subject'       => 'Reset Password!',
                'text_tag'      => 'reset_link',
                'email_body'    => File::get(public_path('email_migrations/user-resetpassword-mail.html')),
                'created_at'    => time()
            )
        );

        DB::table('email_templates')->insert(
            array(
                'slug'          => 'user-change-password-mail',
                'subject'       => 'Password changed!',
                'text_tag'      => 'first_name',
                'email_body'    => File::get(public_path('email_migrations/user-change-password-mail.html')),
                'created_at'    => time()
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
        //
    }
}
