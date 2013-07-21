<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('AdminPageSeeder');
	}

}

class AdminPageSeeder extends Seeder {
	public function run()
	{
		DB::table('users')->delete();

		$user = User::create(array(
			'username' => 'tester',
			'email' => 'ericmenendez@gmail.com',
			'organization' => 'Test Organization',
			'password' => Hash::make('password')
			));

		$phone = Phone::create(array(
			'user_id' => $user->id,
			'email' => '2027310827@vtext.com'
			));

		$location = Location::create(array(
			'phone_id' => $phone->id,
			'location' => 'test location',
			'altitude' => 0,
			'accuracy' => 0,
			'altitudeAccuracy' => 0,
			'heading' => 0,
			'speed' => 0
			));
	}
}