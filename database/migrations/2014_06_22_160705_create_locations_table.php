<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('locations', function($table){
			$table->id();
			$table->foreignId('phone_id')->index();
			$table->double('latitude');
			$table->double('longitude');
			$table->double('altitude')->nullable();
			$table->double('accuracy')->nullable();
			$table->double('altitude_accuracy')->nullable();
			$table->double('heading')->nullable();
			$table->double('speed')->nullable();
			$table->timestamp('location_time')->nullable();
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
		Schema::dropIfExists('locations');
	}
}
