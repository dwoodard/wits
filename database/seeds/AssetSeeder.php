<?php

use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Asset::class, 200)->create();


        factory(App\Asset::class, 1200)->create([
            'department_id' => 2, //IT
             'user_id'=> 11])->each(function ($asset) {

            if((bool)rand(0,1)){
                // $asset->
            }

        });

        factory(App\Asset::class, 1000)->create([
            'department_id' => 1,
            'user_id'=> rand(1, 26)]
        );

        factory(App\Asset::class, 1000)->create([
            'department_id' => 2,
         ])->each(function ($asset) {
            $asset->user_id = rand(1, 26);
            $asset->save();
        });

         factory(App\Asset::class, 500)->create([
            'department_id' => 3,
         ])->each(function ($asset) {
            $asset->user_id = rand(1, 26);
            $asset->save();
        });

         factory(App\Asset::class, 5)->create([
            'department_id' => 4,
             'user_id'=> rand(1, 26)
         ]);
         factory(App\Asset::class, 5)->create([
            'department_id' => 5,
             'user_id'=> rand(1, 26)
         ]);
         factory(App\Asset::class, rand(0,5))->create([
            'department_id' => 1,
             'user_id'=> rand(1, 26)
         ]);


        // factory(App\Asset::class, 10)->create()->each(function ($asset) {
        //     //department && user need to match
        // });




    }
}
