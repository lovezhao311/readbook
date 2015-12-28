<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class Navigation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing navigation
        Schema::create('navigation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid')->index();
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->tinyInteger('sort');
            $table->string('roles');
        });
        Schema::create('roles_navigation' , function(Blueprint $table){
            $table->integer('role_id')->unsigned();
            $table->integer('navigation_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('navigation_id')->references('id')->on('navigation')
                ->onUpdate('cascade')->onDelete('cascade');
            
        });
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