<?php

use Illuminate\Database\Seeder;

class CampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('campus')->insert(['name' => "bc", "code"=>'bc', "latlong"=>'{}']);
        DB::table('campus')->insert(['name' => "ogden", "code"=>'ogden', "latlong"=>'{"lat": 41.192638470302114,"lng": -111.9427574918045}']);
        DB::table('campus')->insert(['name' => "spc", "code"=>'spc', "latlong"=>'{}']);

    }
}
