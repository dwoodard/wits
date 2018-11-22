<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    // use DatabaseTransactions;
    
    /** @test
     * @group login
     */
    public function it_can_get_to_the_root_and_see_login()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/')
                ->assertSee('Login')
            ;
        });
    }

    /** @test 
    * @group login
    */
    public function it_will_login()
    {
        $role = \Spatie\Permission\Models\Role::create(['name' => 'user']);

        $user = factory(\App\User::class)->create([
            "username" => 'foo'
        ]);
        
        $user->assignRole('user');

        $this->browse(function (Browser $browser) use($user) {
            $browser
            // ->loginAs($user)
            ->visit('/browserSync/login/'.$user->username)
            ->assertPathIs('/app');
            ;
        });
    }
   
}
