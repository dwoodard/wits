<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'name' => "Property Control",
            'orgcode' => 00001,
            'phone' => "626-7352",
            'email' => "propertycontrol@weber.edu",
            'primary_contact_name' => "Ian Super cool Awesome Man",
            'parent_department_id' => null,
            ]);

        DB::table('departments')->insert([
            'name' => "IT",
            'orgcode' => 12345,
            'phone' => "555-1234",
            'email' => "bret-assistante@weber.edu",
            'primary_contact_name' => "Bret's assistant to the manager",
            'parent_department_id' => null,
            ]);

        DB::table('departments')->insert([
            'name' => "ATS",
            'orgcode' => 22342,
            'phone' => "555-1235",
            'email' => "shelly@weber.edu",
            'primary_contact_name' => "Shelly",
            'parent_department_id' => 2,
            ]);

        DB::table('departments')->insert([
            'name' => "CATS",
            'orgcode' => 63251,
            'phone' => "626-6410",
            'email' => "aferrin@weber.edu",
            'primary_contact_name' => "Alan",
            'parent_department_id' => 3,
            ]);
        DB::table('departments')->insert([
            'name' => "CTS",
            'orgcode' => 32342,
            'phone' => "555-6545",
            'email' => "mattcain@weber.edu",
            'primary_contact_name' => "Matt",
            'parent_department_id' => 3,
            ]);
        DB::table('departments')->insert([
            'name' => "College of Science",
            'orgcode' => 12342,
            'phone' => "8016267061",
            'email' => "tylerhardy@weber.edu",
            'primary_contact_name' => "Tyler Hardy",
            'parent_department_id' => 5,
            ]);
        DB::table('departments')->insert([
            'name' => "Academic Web Services",
            'orgcode' => 45654,
            'phone' => "8016267077",
            'email' => "jeremyharvey@weber.edu",
            'primary_contact_name' => "Jeremy Harvey",
            'parent_department_id' => 3,
            ]);

    }
}
