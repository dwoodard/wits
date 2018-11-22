<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        if (App::environment() == 'PROD') {
            //PRODUCTION SEEDS

            //roles & properties
            $this->call(PermissionSeeder::class);
            $this->call(RoomStyleSeeder::class);
            $this->call(CampusSeeder::class);
            $this->call(BuildingSeeder::class);
            $this->call(RoomSeeder::class);

            $this->call(DepartmentSeeder::class);

            $this->call(UsersSeeder::class);

        }




        if (App::environment() == 'local') {


            //roles & properties
            $this->call(PermissionSeeder::class);
            $this->call(RoomStyleSeeder::class);
            $this->call(CampusSeeder::class);
            $this->call(BuildingSeeder::class);
            $this->call(RoomSeeder::class);

            $this->call(DepartmentSeeder::class);
            $this->call(UsersSeeder::class);
            $this->call(RoomSoftwareSeeder::class);
            $this->call(AssetSeeder::class);
            $this->call(PropertiesSeeder::class);
            $this->call(DepartmentRoomSeeder::class);
        }







    }
}
