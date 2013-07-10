<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create users table
		Schema::create('users', function($table) {
			$table->increments('id');
			$table->string('username', 320);
			$table->string('email', 320);
			$table->string('organization', 320);
			$table->string('password', 64);
			$table->timestamps();
			$table->timestamp('last_login');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Drop users table
		Schema::drop('users');
	}

}