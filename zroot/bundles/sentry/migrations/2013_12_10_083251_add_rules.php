<?php

class Sentry_Add_Rules {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::connection(Config::get('sentry::sentry.db_instance'))
			->table(Config::get('sentry::sentry.table.rules'))
			->insert(array('rule' => 'is_formadmin', 'description' => 'Form Admin'));
                DB::connection(Config::get('sentry::sentry.db_instance'))
			->table(Config::get('sentry::sentry.table.rules'))
			->insert(array('rule' => 'is_formuser', 'description' => 'Form User'));
                
                DB::connection(Config::get('sentry::sentry.db_instance'))
			->table(Config::get('sentry::sentry.table.rules'))
			->insert(array('rule' => 'is_user', 'description' => 'Is User'));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}