<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PropertiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	 DB::table('properties')->insert([
            'asset_id' => 8,
            'name' => 'mac address wired',
            'value' => 'ab:ab:ab:ab'
            ]);

    	  DB::table('properties')->insert([
            'asset_id' => 8,
            'name' => 'mac address wireless',
            'value' => 'ba:ba:ba:ba'
            ]);

    }
}
