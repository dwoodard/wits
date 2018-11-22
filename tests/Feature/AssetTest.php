<?php

namespace Tests\Feature;

use App\Room;
use App\Building;
use App\Campus;
use App\User;
use App\Department;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AssetTest extends TestCase
{
    use DatabaseMigrations;


    public function setup()
    {
        parent::setUp();
        //set permissions
        \Artisan::call('db:seed',['--class'=>'PermissionSeeder']);
    }

    /** @test */
    public function it_can_see_the_assets_page()
    {

        $user = factory(\App\User::class)->create()->assignRole(['admin', 'user']);
        \Laravel\Passport\Passport::actingAs($user);

        $response = $this->get('/api/v1/asset');

        $response->assertStatus(200);

    }

    /** @test */
    public function it_can_post_an_asset()
    {
        $room = factory(Room::class)->create();
        $building = factory(Building::class)->create();
        $campus = factory(Campus::class)->create();
        $department = factory(Department::class)->create();

        //set permissions
        $user = factory(\App\User::class)->create()->assignRole(['admin', 'user']);
        \Laravel\Passport\Passport::actingAs($user);


        $data = [
            'label' => 'computer',
            'room_id' => $room->id,
            'user_id' => $user->id,
            'department_id' => $department->id,
            'cost' => 5555.55,
        ];

        $response = $this->json('POST', '/api/v1/asset', $data);
        $response ->assertStatus(200);
        $this->assertJson($response->content());
    }

        /** @test
        * @expectedException \Spatie\Permission\Exceptions\UnauthorizedException
        */
    public function it_cant_post_an_asset_without_right_permissions()
    {
        $room = factory(Room::class)->create();
        $building = factory(Building::class)->create();
        $campus = factory(Campus::class)->create();
        $department = factory(Department::class)->create();

        //set permissions
        $user = factory(\App\User::class)->create()->assignRole(['user']);
        \Laravel\Passport\Passport::actingAs($user);


        $data = [
            'label' => 'computer',
            'room_id' => $room->id,
            'user_id' => $user->id,
            'department_id' => $department->id,
            'cost' => 5555.55,
        ];

        $response = $this->json('POST', '/api/v1/asset', $data);
        dump($response->content());
        // $this->setExpectedException('Spatie\Permission\Exceptions\UnauthorizedException'); 
        // $response ->assertStatus(200);
        // $this->assertJson($response->content());
    }

    /** @test */
    public function room_is_required_to_add_an_asset(){

        //Arrange
        $user = factory(\App\User::class)->create()->assignRole(['admin', 'user']);
        \Laravel\Passport\Passport::actingAs($user);
        
        $data = ['name' => 'computer'];

        //Act
        $response = $this->json('POST', '/api/v1/asset', $data);

        //Assert
        $response->assertStatus(422);
        $this->assertArrayHasKey('room_id', $response->decodeResponseJson());

    }




}
