<?php

use Illuminate\Database\Seeder;

class DepartmentRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = App\Department::all();
        $rooms = App\Room::all();
        foreach($departments as $department){

            $department->rooms()->sync($rooms->random()->id);
        }
    }
}
