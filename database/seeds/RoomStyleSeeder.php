<?php

use Illuminate\Database\Seeder;

class RoomStyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_style')->insert(['name' => "Classroom", ]); // 1
        DB::table('room_style')->insert(['name' => "Lab", ]); // 2
        DB::table('room_style')->insert(['name' => "Lecture Hall", ]); // 3
        DB::table('room_style')->insert(['name' => "Office", ]); // 4
        DB::table('room_style')->insert(['name' => "Study Space", ]); // 5
        DB::table('room_style')->insert(['name' => "Storage Space", ]); // 6
        DB::table('room_style')->insert(['name' => "Prep", ]); // 7
        DB::table('room_style')->insert(['name' => "Hallway", ]); // 8
        DB::table('room_style')->insert(['name' => "Conference Room", ]); // 9
        DB::table('room_style')->insert(['name' => "Atrium / Lobby / Corridor / Foyer", ]); // 10
        DB::table('room_style')->insert(['name' => "Theater", ]); // 11
        DB::table('room_style')->insert(['name' => "Data Closet", ]); // 12
        DB::table('room_style')->insert(['name' => "Stairs", ]); // 13
        DB::table('room_style')->insert(['name' => "Custodial", ]); // 14
        DB::table('room_style')->insert(['name' => "Restroom", ]); // 15
    }
}
