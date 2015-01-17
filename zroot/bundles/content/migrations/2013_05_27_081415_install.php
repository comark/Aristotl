<?php

class Content_Install {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::create('contentposts', function($table){
      $table->increments('id')->unsigned();
      $table->string('title');
      $table->text('content');
      $table->string('author_id');
      $table->string('status');
      $table->string('type');      
      $table->string('menus')->nullable();
      $table->integer('order')->nullable();
      $table->string('guid');
      $table->string('template')->nullable();
      $table->string('image')->nullable();
      $table->timestamps();
    });
    
    Schema::create('contenttaxes', function($table){
      $table->increments('id')->unsigned();
      $table->string('title');
      $table->string('status');
      $table->string('guid');
      $table->timestamps();
    });
    
    Schema::create('contentrels', function($table){
      $table->increments('id')->unsigned();
      $table->integer('posts_id');
      $table->integer('taxs_id');
      $table->integer('deleted')->default(0);
      $table->timestamps();
    });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contentposts');
    Schema::drop('contenttaxs');
    Schema::drop('contentrels');
	}

}