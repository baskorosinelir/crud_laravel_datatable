<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker::create();
    	for($i = 1; $i <= 20; $i++){
 
    	      // insert data ke table pegawai menggunakan Faker
    		DB::table('persons')->insert([
    			'name' => $faker->name,
    			'email' => $faker->email,
    			'address' => $faker->address
    		]);
 
    	}
    }
}
