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
			$table->string('location', 64);
			$table->float('altitude')->nullable();
			$table->float('accuracy')->nullable();
			$table->float('altitudeAccuracy')->nullable();
			$table->float('heading')->nullable();
			$table->float('speed')->nullable();
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
