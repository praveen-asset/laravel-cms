<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CmsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('cms')->insert(
            array(
                'slug'              =>  'about-us-page',
                'title'             =>  'About Us',
                'content'           =>  File::get(public_path('cms_migrations/about.html')),
                'status'            =>  '1', 
                'created_at'        =>  time(),
                'updated_at'         =>  time(),
            )
        );

        DB::table('cms')->insert(
            array(
                'slug'              =>  'privacy-policy-page',
                'title'             =>  'Privacy Policy',
                'content'           =>  File::get(public_path('cms_migrations/policy.html')),
                'status'            =>  '1', 
                'created_at'        =>  time(),
                'updated_at'         =>  time(),
            )
        );

        DB::table('cms')->insert(
            array(
                'slug'              =>  'terms-of-use-page',
                'title'             =>  'Terms of Use',
                'content'           =>  File::get(public_path('cms_migrations/terms.html')),
                'status'            =>  '1', 
                'created_at'        =>  time(),
                'updated_at'         =>  time(),
            )
        );

        DB::table('cms')->insert(
            array(
                'slug'              =>  'copyright',
                'title'             =>  'Copyright',
                'content'           =>  File::get(public_path('cms_migrations/copyright.html')),
                'status'            =>  '1', 
                'created_at'        =>  time(),
                'updated_at'         =>  time(),
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
