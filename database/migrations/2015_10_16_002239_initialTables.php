<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            /* @var $table \Illuminate\Database\Schema\Blueprint */
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        
        Schema::create('photos', function (Blueprint $table) {
            /* @var $table \Illuminate\Database\Schema\Blueprint */
            $table->increments('id');
            $table->integer('album_id')->unsigned();
            $table->string('path');
            $table->timestamps();
            
            $table->foreign('album_id')->references('id')->on('albums');
        });
        
        Schema::create('tags', function (Blueprint $table) {
            /* @var $table \Illuminate\Database\Schema\Blueprint */
            $table->increments('id');
            $table->integer('photo_id')->unsigned();
            $table->string('name');
            $table->timestamps();
            
            $table->foreign('photo_id')->references('id')->on('photos');
        });
        
        Schema::create('album_users', function (Blueprint $table) {
            /* @var $table \Illuminate\Database\Schema\Blueprint */
            $table->integer('album_id')->unsigned();
            $table->integer('user_id')->unsigned();
            
            $table->foreign('album_id')->references('id')->on('albums');
            $table->foreign('user_id')->references('id')->on('users');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('is_admin')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            /* @var $table Illuminate\Database\Schema\Blueprint */
            $table->dropColumn('is_admin');
        });
        Schema::drop('tags');
        Schema::drop('album_users');
        Schema::drop('photos');
        Schema::drop('albums');
    }
}
