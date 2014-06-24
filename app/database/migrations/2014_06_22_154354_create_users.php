<?php

use Illuminate\Database\Schema\Blueprint;
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
			$table->string('email', 320);
			$table->string('organization', 320);
			$table->string('password', 64);
			$table->timestamps();
			$table->timestamp('last_login');
			$table->string('remember_token', 100)->nullable();
		});

		// Add Guest user
		DB::insert('insert into users (id, email, organization, password) values (?, ?, ?, ?)', array(1, 'Guest', '', Hash::make('')));
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
