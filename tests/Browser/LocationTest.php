<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use \App\RoomStyle;
use Auth;
class LocationTest extends DuskTestCase
{
    use DatabaseMigrations;
    // use DatabaseTransactions;

    /**
    * @test
    * @group location
    * will add a campus, building, and room
    */
    public function it_will_add_a_location()
    {
        \Artisan::call('db:seed',['--class'=>'PermissionSeeder']);
        \Artisan::call('db:seed',['--class'=>'RoomStyleSeeder']);

        $user = factory(\App\User::class)->create(["username" => 'foo']);
        $user->assignRole('admin');
        Auth::login($user);

        $this->browse(function (Browser $browser) use($user) {
            $browser
            ->loginAs($user)
            ->visit('/app/locations')
            // ->visit('/browserSync/login/'.$user->username)
            // ->clickLink('Locations')
            ->assertPathIs('/app/locations')
            ;

            $browser->pause(3000);
            $browser->keys('#addCampusName', 'c1', '{TAB}', '123456', '{ENTER}');
            $browser->pause(3000);
            $browser->assertSee('c1');

            $browser->keys('#campusDropdown', '{ARROW_DOWN}') ;
            $browser->keys('#addBuilding', 'b1', '{TAB}');
            $browser->keys('#addBuildingCode', 'b1', '{ENTER}');
            $browser->pause(3000);
            $browser->assertSee('b1');
            $browser->keys('#buildingDropdown', '{ARROW_DOWN}') ;
            $browser->pause(3000);

            $browser->keys('#addRoomName', 'one0one');
            $browser->keys('#addRoomNumber', '101');
            $browser->select('#addRoomStyle', '1');
            $browser->click('#addRoomSubmit');
            $browser->pause(3000);
            $browser->keys('#roomDropdown', '{ARROW_DOWN}' );
            $browser->pause(3000);
            $browser->assertSee('Room: 101');
            ;

        });
    }

}
