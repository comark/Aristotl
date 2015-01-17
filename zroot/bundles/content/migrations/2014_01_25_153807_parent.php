<?php

class Content_Parent {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::table('contentposts', function($table){
             $table->string('parent')->nullable();
             $table->string('inactiveurl')->nullable();
            });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::table('contentposts', function($table){
             $table->drop_column('parent');
             $table->drop_column('inactiveurl');
            });
	}

}