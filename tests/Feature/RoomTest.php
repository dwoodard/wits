<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoomTest extends TestCase
{
    use DatabaseMigrations;

    public function setup()
    {
        parent::setUp();
        //set permissions
        \Artisan::call('db:seed',['--class'=>'PermissionSeeder']);
    }

    /** @test */
    public function it_can_post_a_room()
    {
        $roomstyle = factory(\App\RoomStyle::class)->create();
        $building = factory(\App\Building::class)->create();

        //set permissions
        $user = factory(\App\User::class)->create()->assignRole(['admin', 'user']);
        \Laravel\Passport\Passport::actingAs($user);

        $data = [
        'style_id' => $roomstyle->id,
        'building_id' => $building->id,
        'number' => '100',
        'name' => 'roomname',
        'capacity' => 10,
        ];

        $response = $this->json('POST', '/api/v1/rooms', $data);
        $response->assertStatus(200);
        $this->assertJson($response->content());
    }

}
