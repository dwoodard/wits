<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (App::environment() == 'local') {

            factory(App\User::class, 5)->create()->each(function($user){
                $user->assignRole('user');
                $user->departments()->sync([2]);

            });

            factory(App\User::class, 5)->create()->each(function($user){
                $user->assignRole('user');
                $user->departments()->sync([3]);

            });
            factory(App\User::class, 5)->create()->each(function($user){
                $user->assignRole('user');
                $user->departments()->sync([4]);

            });
            factory(App\User::class, 5)->create()->each(function($user){
                $user->assignRole('user');
                $user->departments()->sync([5]);

            });
            factory(App\User::class, 5)->create()->each(function($user){
                $user->assignRole('user');
                $user->departments()->sync([6]);

            });



        }

         /**/
            $user = App\User::create([
                'first_name' => 'Dustin',
                'last_name' => 'Woodard',
                'username' => 'dustinwoodard',
                'email' => 'dustinwoodard@weber.edu',
                'password' => bcrypt('demo'),
            ]);
            $user->assignRole(['admin', 'user']);
            $user->departments()->sync([3]);

        if (App::environment() == 'PROD' || App::environment() == 'local') {
        //$user = App\User::find(['first_name' => 'Dustin', 'last_name' => 'Woodard', 'username' => 'dustinwoodard', 'email' => 'dustinwoodard@weber.edu', 'password' => bcrypt('demo'), ]); $user->assignRole(['admin', 'user']); $user->departments()->sync([2]);


            /**/
            $user = App\User::create([
                'first_name' => 'Matt',
                'last_name' => 'Cain',
                'username' => 'mattcain',
                'email' => 'mattcain@weber.edu',
                'password' => bcrypt('demo'),
            ]);
            $user->assignRole(['admin', 'user', 'room_support']);
            $user->departments()->sync([5]);

            /**/
            $user = App\User::create([
                'first_name' => 'Adam',
                'last_name' => 'Farrell',
                'username' => 'adamfarrell',
                'email' => 'adamfarrell@weber.edu',
                'password' => bcrypt('demo'),
            ]);
            $user->assignRole(['admin', 'user']);
            $user->departments()->sync([7]);

            /**/
            $user = App\User::create([
                'first_name' => 'Shelly',
                'last_name' => 'Belflower',
                'username' => 'sbelflower',
                'email' => 'sbelflower@weber.edu',
                'password' => bcrypt('demo'),
            ]);
            $user->assignRole(['department_admin', 'user']);
            // $user->departments()->sync([6]);


            //CATS
            $user = App\User::create([
                'first_name' => 'Alan',
                'last_name' => 'Ferrin',
                'username' => 'aferrin',
                'email' => 'aferrin@weber.edu',
                'password' => bcrypt('demo'),
            ]);
            $user->assignRole(['department_admin', 'user']);
            // $user->departments()->sync([5]);

            /**/
            $user = App\User::create([
                'first_name' => 'Joe',
                'last_name' => 'Salmond',
                'username' => 'josephsalmond',
                'email' => 'josephsalmond@weber.edu',
                'password' => bcrypt('demo'),
            ]);
            $user->assignRole(['department_user', 'user']);
            // $user->departments()->sync([5]);

            /**/
            $user = App\User::create([
                'first_name' => 'Ryan',
                'last_name' => 'Belnap',
                'username' => 'ryanbelnap1',
                'email' => 'ryanbelnap1@weber.edu',
                'password' => bcrypt('demo'),
            ]);
            $user->assignRole(['department_user', 'user']);
            // $user->departments()->sync([5]);

            /**/
            $user = App\User::create([
                'first_name' => 'David',
                'last_name' => 'Rodriguez',
                'username' => 'davidrodriguez1',
                'email' => 'davidrodriguez1@weber.edu',
                'password' => bcrypt('demo'),
            ]);
            $user->assignRole(['department_user', 'user']);
            // $user->departments()->sync([5]);

            /**/
            $user = App\User::create([
                'first_name' => 'Jim',
                'last_name' => 'godwin',
                'username' => 'jamesgodwin',
                'email' => 'jamesgodwin@weber.edu',
                'password' => bcrypt('demo'),
            ]);
            $user->assignRole(['department_user', 'user']);
            // $user->departments()->sync([5]);


            /**/
            $user = App\User::create([
                'first_name' => 'Tyler',
                'last_name' => 'Hardy',
                'username' => 'tylerhardy',
                'email' => 'tylerhardy@weber.edu',
                'password' => bcrypt('demo'),
            ]);
            $user->assignRole(['department_user', 'user']);
            // $user->departments()->sync([5]);


            /**/
            $user = App\User::create([
                'first_name' => 'Mark',
                'last_name' => 'Ashby',
                'username' => 'markashby1',
                'email' => 'markashby1@weber.edu',
                'password' => bcrypt('demo'),
            ]);
            $user->assignRole(['department_user', 'user']);
            // $user->departments()->sync([5]);

            /**/
            $user = App\User::create([
                'first_name' => 'Stephen',
                'last_name' => 'Cain',
                'username' => 'stephencain',
                'email' => 'stephencain@weber.edu',
                'password' => bcrypt('demo'),
            ]);
            $user->assignRole(['admin', 'user']);
            // $user->departments()->sync([5]);

}


    }
}
