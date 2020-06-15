<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('phones', function($table){
			$table->id();
			$table->string('token', 4)->nullable();
			$table->foreignId('user_id')->nullable()->index();
			$table->string('number', 20)->nullable();
			$table->string('user_agent', 320)->nullable();
			$table->ipAddress('ip')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('phones');
	}
}
