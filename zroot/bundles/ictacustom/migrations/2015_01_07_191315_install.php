<?php

class Ictacustom_Install {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('ictacustom', function($table){
              $table->increments('id')->unsigned();
              $table->string('type');
              $table->string('title');
              $table->string('guid');
              $table->text('meta');
              $table->string('status');     
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
	Schema::drop('ictacustom');
	}

}