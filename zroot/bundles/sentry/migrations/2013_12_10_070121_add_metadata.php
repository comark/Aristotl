<?php

class Sentry_Add_Metadata {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::table(Config::get('sentry::sentry.table.users_metadata'), function($table){
             $table->string('avatar');
             $table->text('restricted_access')->nullable();
            });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::table(Config::get('sentry::sentry.table.users_metadata'), function($table){
             $table->drop_column('avatar');
             $table->drop_column('restricted_access');
            });
	}

}