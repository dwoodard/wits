<?php

use Illuminate\Database\Seeder;

class ProdDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        //PRODUCTION SEEDS

        //roles & properties
        $this->call(PermissionSeeder::class);
        $this->call(CampusSeeder::class);
        $this->call(BuildingSeeder::class);
        $this->call(RoomStyleSeeder::class);


        // if (getenv('APP_SEED'))
        // {
        //     //Staging Seeds
        //     $this->call(RoomSeeder::class);
        //     $this->call(DepartmentSeeder::class);

        //     // $this->call(BuildingDepartmentSeeder::class);
        //     $this->call(UsersSeeder::class);
        //     // $this->call(DepartmentOrgSeeder::class);

        //     // $this->call(SupportSeeder::class);
        //     $this->call(RoomSoftwareSeeder::class);
        //     $this->call(AssetSeeder::class);
        //     $this->call(PropertiesSeeder::class);

        //     $this->call(DepartmentRoomSeeder::class);
        //     // $this->call(CheckoutSeeder::class);
        //     // $this->call(MediaSeeder::class);
        // }

    }
}
