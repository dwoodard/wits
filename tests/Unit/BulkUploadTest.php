<?php
// run test in cli
// phpunit tests/Unit/BulkUploadTest.php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use League\Csv\Reader;
use League\Csv\Writer;
use SplFileObject;

// use App\User;
// use Laravel\Passport\Passport;
// use SplFileObject;
// use Auth;
use Illuminate\Http\UploadedFile;
use Exception;

use App\Bulkupload\BulkUploadAsset;

class BulkUploadTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    private function getTemplateFile()
    {
        $file = public_path() . "/downloads/BulkUploadTemplate.csv";
        $file = new UploadedFile($file, 'BulkUploadTemplate.csv',  null, null, null, true);
        return $file;
    }

    public function createAssetDependencies($overwrite=Array())
    {

        /** usage
        $dependencies = $this->createAssetDependencies([
            'user' => ['username'=> 'user1', 'email'=>'user1@email.com'],
            'building' => ['code'=> 'AB'],
            'category' => ['name' => ''],
            'room' => ['number' => '101'],
            'department' => ['orgcode' => '456'],
        ]);
        */


        $default = [
           'user' => ['username'=> 'user1'],
           'building' => ['code'=> 'lp'],
           'category' => ['name' => '', 'lifecycle'=>null],
           'room' => ['number' => '204'],
           'department' => ['orgcode' => '123'],
        ];

        $data = array_intersect_key($overwrite + $default, $default);

        $user = factory(\App\User::class)->create($data['user']);
        $building = factory(\App\Building::class)->create($data['building']);
        $room = factory(\App\Room::class)->create($data['room']);
        $department = factory(\App\Department::class)->create($data['department']);

        return $data;
    }

    private function setFakeData($bulkupload, $csv=Array())
    {

        $default = [
            'ws1234567',         // 0 "weber_inventory_tag"
            'computer',          // 1 "category"
            'apple',             // 2 "manufacturer"
            'starwest',          // 3 "vendor"
            'm-123',             // 4 "model"
            'ab:ab:ab:ab:ab:ab',   // 5 "wired_mac_address"
            'ba:ba:ba:ba:ba:ba',   // 6 "wireless_mac_address"
            'serial123',         // 7 "serial_number"
            'user1',             // 8 "username"
            'lp',                // 9 "building_code"
            '204',               // 10 "room_id"
            '2018-03-23',        // 11 "acquisition_date"
            '123.00',            // 12 "cost"
            'p0123',             // 13 "po_number"
            '123',               // 14 "org_code"
            'user1 computer',    // 15 "label"
            'some notes',        // 16 "description_notes"
        ];

        $bulkupload->csv->push(array_intersect_key($csv + $default, $default));



    }

    /** @test */
    public function it_takes_the_bulk_upload_assets_template_in_the_downloads_directory_and_validate_headers()
    {
        $bulkupload = new BulkuploadAsset($this->getTemplateFile());

        $this->assertTrue($bulkupload->headers[0] == 'weber_inventory_tag');
        $this->assertTrue($bulkupload->headers[1] == 'category');
        $this->assertTrue($bulkupload->headers[2] == 'manufacturer');
        $this->assertTrue($bulkupload->headers[3] == 'vendor');
        $this->assertTrue($bulkupload->headers[4] == 'model');
        $this->assertTrue($bulkupload->headers[5] == 'wired_mac_address');
        $this->assertTrue($bulkupload->headers[6] == 'wireless_mac_address');
        $this->assertTrue($bulkupload->headers[7] == 'serial_number');
        $this->assertTrue($bulkupload->headers[8] == 'username');
        $this->assertTrue($bulkupload->headers[9] == 'building_code');
        $this->assertTrue($bulkupload->headers[10] == 'room_number');
        $this->assertTrue($bulkupload->headers[11] == 'acquisition_date');
        $this->assertTrue($bulkupload->headers[12] == 'cost');
        $this->assertTrue($bulkupload->headers[13] == 'po_number');
        $this->assertTrue($bulkupload->headers[14] == 'org_code');
        $this->assertTrue($bulkupload->headers[15] == 'short_description');
        $this->assertTrue($bulkupload->headers[16] == 'long_description');
    }

    /* @test */
    public function it_uses_bulkupload_asset_class()
    {
        $bulkupload = new BulkuploadAsset($this->getTemplateFile());
        $this->assertInstanceOf(BulkuploadAsset::class, $bulkupload);
    }

    /** @test */
    public function it_checks_if_file_is_csv()
    {
        $bulkupload = new BulkuploadAsset($this->getTemplateFile());
        $this->assertEquals('csv', $bulkupload->file->getClientOriginalExtension());
    }

    /** @test */
    public function it_receives_an_upload_file()
    {

        // take fake download
        // edit file to have fake data
        // validate it
        // and upload it to api/v1/bulkupload/assets


        $file = public_path() . "/downloads/BulkUploadTemplate.csv";
        $file = new UploadedFile($file, 'file',  null, null, null, true);

        $response = $this->json('POST','/api/v1/bulkupload/assets', ['upload'=>$file]);
        $response->assertStatus(200);
        // dump($response);

    }

    /** @test */
    public function it_adds_3_assets_via_api()
    {
        $dependencies = $this->createAssetDependencies();

        // create a temp file
        // copy template csv to temp file
        // load file into Writer CSV
        // add 5 items (fails:2, passes:3) to csv Fail: [2,4] Pass: [1,3,5]
        // upload
        // check for 3 successful assets

        $temp = tmpfile();
        // dump($temp);

        $template = public_path() . "/downloads/BulkUploadTemplate.csv";

        // dump(file_get_contents($template));

        fwrite($temp, file_get_contents($template));
        fseek($temp,0,SEEK_END);

        $csv = Writer::createFromStream($temp,'r+');

        $data = [
            [                    //PASS
            '100000000',         // 0 "weber_inventory_tag"
            'computer',          // 1 "category"
            'apple',             // 2 "manufacturer"
            'starwest',          // 3 "vendor"
            'm-123',             // 4 "model"
            'ab:ab:ab:ab:ab:ab',   // 5 "wired_mac_address"
            'ba:ba:ba:ba:ba:ba',   // 6 "wireless_mac_address"
            'serial123',         // 7 "serial_number"
            'user1',             // 8 "username"
            'LP',                // 9 "building_code"
            '204',               // 10 "room_id"
            '2018-03-23',        // 11 "acquisition_date"
            '123.00',            // 12 "cost"
            'p0123',             // 13 "po_number"
            '123',               // 14 "org_code"
            'user1 computer',    // 15 "label"
            'some notes',        // 16 "description_notes"
            ],
            [                    //PASS - No weber inventory tag
            '',                  // 0 "weber_inventory_tag"
            'computer',          // 1 "category"
            'apple',             // 2 "manufacturer"
            'starwest',          // 3 "vendor"
            'm-123',             // 4 "model"
            'ab:ab:ab:ab:ab:ab',   // 5 "wired_mac_address"
            'ba:ba:ba:ba:ba:ba',   // 6 "wireless_mac_address"
            'serial123',         // 7 "serial_number"
            'user1',             // 8 "username"
            'LP',                // 9 "building_code"
            '204',               // 10 "room_id"
            '2018-03-23',        // 11 "acquisition_date"
            '123.00',            // 12 "cost"
            'p0123',             // 13 "po_number"
            '123',               // 14 "org_code"
            'user1 computer',    // 15 "label"
            'some notes',        // 16 "description_notes"
            ],
            [                    //PASS
            '000000003',         // 0 "weber_inventory_tag"
            'computer',          // 1 "category"
            'apple',             // 2 "manufacturer"
            'starwest',          // 3 "vendor"
            'm-123',             // 4 "model"
            'ab:ab:ab:ab:ab:ab',   // 5 "wired_mac_address"
            'ba:ba:ba:ba:ba:ba',   // 6 "wireless_mac_address"
            'serial123',         // 7 "serial_number"
            'user1',             // 8 "username"
            'LP',                // 9 "building_code"
            '204',               // 10 "room_id"
            '2018-03-23',        // 11 "acquisition_date"
            '123.00',            // 12 "cost"
            'p0123',             // 13 "po_number"
            '123',               // 14 "org_code"
            'user1 computer',    // 15 "label"
            'some notes',        // 16 "description_notes"
            ],
            [                    //Fail - duplicate
            '000000003',         // 0 "weber_inventory_tag"
            'computer',          // 1 "category"
            'apple',             // 2 "manufacturer"
            'starwest',          // 3 "vendor"
            'm-123',             // 4 "model"
            'ab:ab:ab:ab:ab:ab',   // 5 "wired_mac_address"
            'ba:ba:ba:ba:ba:ba',   // 6 "wireless_mac_address"
            'serial123',         // 7 "serial_number"
            'user1',             // 8 "username"
            'LP',                // 9 "building_code"
            '204',               // 10 "room_id"
            '2018-03-23',        // 11 "acquisition_date"
            '123.00',            // 12 "cost"
            'p0123',             // 13 "po_number"
            '123',               // 14 "org_code"
            'user1 computer',    // 15 "label"
            'some notes',        // 16 "description_notes"
            ],
            [                    //PASS
            '000000005',         // 0 "weber_inventory_tag"
            'computer',          // 1 "category"
            'apple',             // 2 "manufacturer"
            'starwest',          // 3 "vendor"
            'm-123',             // 4 "model"
            'ab:ab:ab:ab:ab:ab',   // 5 "wired_mac_address"
            'ba:ba:ba:ba:ba:ba',   // 6 "wireless_mac_address"
            'serial123',         // 7 "serial_number"
            'user1',             // 8 "username"
            'LP',                // 9 "building_code"
            '204',               // 10 "room_id"
            '2018-03-23',        // 11 "acquisition_date"
            '123.00',            // 12 "cost"
            'p0123',             // 13 "po_number"
            '123',               // 14 "org_code"
            'user1 computer',    // 15 "label"
            'some notes',        // 16 "description_notes"
            ],
        ];
        $csv->insertAll($data);

        // dump(file_get_contents(stream_get_meta_data($temp)['uri']));


        $file = new UploadedFile(stream_get_meta_data($temp)['uri'], 'file',  null, null, null, true);
        $response = $this->json('POST','/api/v1/bulkupload/assets', ['upload'=>$file]);
        $response->assertStatus(200);

        $assets = \App\Asset::all()->toArray();
        // dump($assets);

        $this->assertEquals(4, count($assets));


        // fwrite($temp, file_get_contents($template));

    }

    /** @test */
    public function it_gets_expected_data_from_rows()
    {
        $bulkupload = new BulkuploadAsset($this->getTemplateFile());

        $this->setFakeData($bulkupload);

        $this->assertEquals('ws1234567', $bulkupload->csv[0][0]);
        $this->assertEquals('computer', $bulkupload->csv[0][1]);
        $this->assertEquals('apple', $bulkupload->csv[0][2]);
        $this->assertEquals('starwest', $bulkupload->csv[0][3]);
        $this->assertEquals('m-123', $bulkupload->csv[0][4]);
        $this->assertEquals('ab:ab:ab:ab:ab:ab', $bulkupload->csv[0][5]);
        $this->assertEquals('ba:ba:ba:ba:ba:ba', $bulkupload->csv[0][6]);
        $this->assertEquals('serial123', $bulkupload->csv[0][7]);
        $this->assertEquals('user1', $bulkupload->csv[0][8]);
        $this->assertEquals('lp', $bulkupload->csv[0][9]);
        $this->assertEquals('204', $bulkupload->csv[0][10]);
        $this->assertEquals('2018-03-23', $bulkupload->csv[0][11]);
        $this->assertEquals('123.00', $bulkupload->csv[0][12]);
        $this->assertEquals('p0123', $bulkupload->csv[0][13]);
        $this->assertEquals('123', $bulkupload->csv[0][14]);
        $this->assertEquals('user1 computer', $bulkupload->csv[0][15]);
        $this->assertEquals('some notes', $bulkupload->csv[0][16]);
    }

    /** @test */
    public function it_validates_then_adds_assets_from_csv()
    {
        //fake data to check if numbers are right and not just the first item
        // factory(\App\Room::class)->create(['number' => 111, 'building_id' => 1]);
        // factory(\App\Room::class)->create(['number' => 111, 'building_id' => 1]);
        // factory(\App\Building::class)->create(['code' => 'ZZ']);
        // factory(\App\User::class)->create(['username' => 'otheruser', 'email'=> 'otheruser@example.com']);
        // factory(\App\Department::class)->create(['orgcode' => '000']);


        $bulkupload = new BulkuploadAsset($this->getTemplateFile());

        $data = $this->setFakeData($bulkupload);
        // dump($data['user']);

        $this->assertEquals('ws1234567', $bulkupload->csv[0][0]);
        $this->assertEquals('m-123', $bulkupload->csv[0][4]);
        $this->assertEquals('serial123', $bulkupload->csv[0][7]);
        // $this->assertEquals($data['user']->username, $bulkupload->csv[0][8]);
        // $this->assertEquals($data['building']->code, $bulkupload->csv[0][9]);
        // $this->assertEquals($data['room']->number, $bulkupload->csv[0][10]);
        // $this->assertEquals($data['department']->orgcode, $bulkupload->csv[0][14]);

        $bulkupload->process();

        // dump($bulkupload->assets->toArray());

        // $this->assertEquals($bulkupload->csv[0][0], $bulkupload->assets[0]->weber_inventory_tag);

        //has 1 asset of data
        $asset = \App\Asset::find(1);
        // $this->assertEquals($bulkupload->csv[0][0], $asset->weber_inventory_tag);

        // $this->assertTrue(1 == $asset->department_id);
        // $this->assertTrue(1 == $asset->user_id);

        // dump($asset->toArray());
        // dump($asset->user_id);
        // dump($bulkupload);

        // $this->assertNull($bulkupload->failed);
    }

    /** @test */
    public function fails_if_upload_file_is_not_given()
    {
        $this->setExpectedException('Exception');
        // If not an instance of UploadedFile should give an exception
        $bulkupload = new BulkuploadAsset('');
    }


    /*
    Validation for each field
    */



    /** @test */
    public function it_validates_weber_inventory_tag_for_duplicates()
    {
        $dependencies = $this->createAssetDependencies();

        $ba1 = new BulkuploadAsset($this->getTemplateFile());
        $this->setFakeData($ba1, [0=>"123456789"]); //0 make an asset
        $this->setFakeData($ba1, [0=>'123456789', 1=>'duplicate']); //1 should be unique
        $this->setFakeData($ba1, [0=>"123456780"]);
        $ba1->process();
        // $ba1->debug();
        $this->assertEquals(2,\App\Asset::all()->count());
        $this->assertContains("has already been taken",$ba1->failed[0]['errors']->getMessages()[0][0]);
    }

    /** @test */
    public function it_validates_weber_inventory_tag()
    {
        $dependencies = $this->createAssetDependencies();

        $ba1 = new BulkuploadAsset($this->getTemplateFile());

        // failed
        $this->setFakeData($ba1, [0=>"!@#"]); //should be alphanumeric


        //pass
        $this->setFakeData($ba1, [0=>""]); //should allow null
        $this->setFakeData($ba1, [0=>"ws1234567"]); //should allow lowercase
        $this->setFakeData($ba1, [0=>"WS1234567"]); //should allow upper
        $this->setFakeData($ba1, [0=>"013456789"]); //should be 9 digits


        $ba1->process();
        // $ba1->debug();
        // $ba1->debug(true);

        $assets = \App\Asset::all();

        $this->assertEquals(1, $ba1->failed->count()); //failed
        $this->assertEquals(4, $assets->count()); //passed

        // Assert failed
        // $this->assertContains("may only contain letters and numbers",$ba1->failed[0]['errors']->getMessages()[0][0]);


        // Assert passed
        $this->assertEquals("",$ba1->assets[0]->weber_inventory_tag);
        $this->assertEquals("ws1234567",$ba1->assets[1]->weber_inventory_tag);
        $this->assertEquals("WS1234567",  $ba1->assets[2]->weber_inventory_tag);
        $this->assertEquals("013456789",  $ba1->assets[3]->weber_inventory_tag);


    }

    /** @test */
    public function it_validates_category()
    {
        $dependencies1 = $this->createAssetDependencies();

        $dependencies2 = $this->createAssetDependencies([
            'user' => ['email'=> 'user2@mail.com'],
            'category' => ['name' => 'computer'],
        ]);

        // dump(\App\Category::all()->toArray());

        $ba1 = new BulkuploadAsset($this->getTemplateFile());
        $this->setFakeData($ba1, [0=>"000000000",1=>"!@#"]); //0 should be alpha and fail
        $this->setFakeData($ba1, [0=>"000000001",1=>""]); //1 should leave it blank if string is empty and create the asset
        $this->setFakeData($ba1, [0=>"000000002",1=>"Computer"]); //2 should name and create the asset
        $this->setFakeData($ba1, [0=>"000000003",1=>""]); //3 should get the id from the category name and create the asset

        $ba1->process();
        // $ba1->debug();
        // $ba1->debug(true);

        $this->assertEquals("",$ba1->assets[0]->category);
        $this->assertEquals("Computer",  $ba1->assets[1]->category);
        $this->assertEquals(null,  $ba1->assets[2]->category);
        // dump($ba1->failed[0]['errors']->getMessages()[1][0]);
        $this->assertContains("may only contain letters", $ba1->failed[0]['errors']->getMessages()[1][0]);

    }

    /** @test */
    public function it_validates_manufacturer()
    {
        $dependencies = $this->createAssetDependencies();

        $ba1 = new BulkuploadAsset($this->getTemplateFile());
        $this->setFakeData($ba1, [0=>"000000000",2=>"apple"]);
        $this->setFakeData($ba1, [0=>"000000001",2=>""]); //should be required


        $ba1->process();
        // $ba1->debug();
        // $ba1->debug(true);

        $assets = \App\Asset::all();

        $this->assertContains("required",$ba1->failed[0]['errors']->getMessages()[2][0]);
        $this->assertEquals("apple",$assets[0]->manufacturer);



    }

    /** @test */
    public function it_validates_vendor()
    {
        $dependencies = $this->createAssetDependencies();

        $ba1 = new BulkuploadAsset($this->getTemplateFile());
        $this->setFakeData($ba1, [3=>"foobar"]);

        $ba1->process();
        // $ba1->debug();

        $this->assertEquals("foobar",$ba1->assets[0]->vendor);
    }

    /** @test */
    public function it_validates_model()
    {
        $dependencies = $this->createAssetDependencies();

        $ba1 = new BulkuploadAsset($this->getTemplateFile());
        $this->setFakeData($ba1, [4=>"abc123"]);

        $ba1->process();
        // $ba1->debug();

        $this->assertEquals("abc123",$ba1->assets[0]->model);
    }

    /** @test */
    public function it_validates_wired_mac_address()
    {
        $dependencies = $this->createAssetDependencies();

        $ba1 = new BulkuploadAsset($this->getTemplateFile());
        $this->setFakeData($ba1, [5=>"ab:ab:ab:ab:ab"]);
        $this->setFakeData($ba1, [0 => '000000001', 5 => "ab:ab:ab:ab:ab:ab", 6 => ""]);

        $ba1->process();
        // $ba1->debug(true);

        $this->assertContains("wired_mac_address format is invalid", $ba1->failed[0]['errors']->getMessages()[5][0]);
        $asset = \App\Asset::find(1)->with('properties')->get()->first();
        // dump($asset->properties->toArray());
        $this->assertEquals("ab:ab:ab:ab:ab:ab",$asset->properties[0]->value);
    }

    /** @test */
    public function it_validates_wireless_mac_address()
    {
        $dependencies = $this->createAssetDependencies();

        $ba1 = new BulkuploadAsset($this->getTemplateFile());
        $this->setFakeData($ba1, [6 => "ba:ba:ba:ba:ba"]);
        $this->setFakeData($ba1, [0 => '000000001', 6=>"ab:ab:ab:ab:ab:ab", 5=>""]);

        $ba1->process();
        // $ba1->debug(true);

        $this->assertContains("wireless_mac_address format is invalid", $ba1->failed[0]['errors']->getMessages()[6][0]);
        $asset = \App\Asset::find(1)->with('properties')->get()->first();
        // dump($asset->properties->toArray());
        $this->assertEquals("ab:ab:ab:ab:ab:ab",$asset->properties[0]->value);
    }

    /** @test */
    public function it_validates_serial_number()
    {
        $dependencies = $this->createAssetDependencies();

        $ba1 = new BulkuploadAsset($this->getTemplateFile());
        // $this->setFakeData($ba1, [0=>"000000001", 7=>'']); //0 required

        $ba1->process();
        // $ba1->debug();

        // $this->assertContains("required", $ba1->failed[0]['errors']->getMessages()[7][0]);

    }

    /** @test */
    public function it_validates_username()
    {
        $dependencies = $this->createAssetDependencies();

        $ba1 = new BulkuploadAsset($this->getTemplateFile());
        $this->setFakeData($ba1, [8=>'']); //0 required
        $this->setFakeData($ba1, [8=>'user1']);

        $ba1->process();
        // $ba1->debug();
        $asset = \App\Asset::find(1)->first();
        // dump($asset->toArray());
        $this->assertEquals(1,$asset->user_id);

        $this->assertContains("required", $ba1->failed[0]['errors']->getMessages()[8][0]);
    }

    /** @test */
    public function it_validates_building_code_and_room_id()
    {
        $dependencies = $this->createAssetDependencies();

        $ba1 = new BulkuploadAsset($this->getTemplateFile());
        $this->setFakeData($ba1, [9=>'', 10=>'']); //0 required
        $this->setFakeData($ba1); //1
        $this->setFakeData($ba1, [0=>'000000001', 9=>'LP', 10=>'204']); //2 Upper to lower lp

        $ba1->process();
        // $ba1->debug();
        // $ba1->debug(true);

        $assets = \App\Asset::with('room.building')->get();
        // dump($assets->toArray());
        $this->assertEquals(1,$assets[0]->room_id);
        $this->assertEquals(1,$assets[0]->room->id);
        $this->assertEquals(1,$assets[1]->room->building->id);

        $this->assertContains("required", $ba1->failed[0]['errors']->getMessages()[9][0]);
        $this->assertContains("required", $ba1->failed[0]['errors']->getMessages()[10][0]);

        // $this->assertEquals('lp', $ba1->csv[2][9]); //LP was lowercased to lp

    }

    /** @test */
    public function it_validates_acquisition_date()
    {
        $dependencies = $this->createAssetDependencies();

        $ba1 = new BulkuploadAsset($this->getTemplateFile());
        $this->setFakeData($ba1, [11=>"bad-date"]); //0 should be a valid date
        $this->setFakeData($ba1, [11=>"0000-00-00"]); //1 should be a valid date
        $this->setFakeData($ba1, [11=>"0000-0-0"]); //2 should be a valid date
        $this->setFakeData($ba1, [11=>"2018-99-99"]); //3 should be a valid date
        $this->setFakeData($ba1, [11=>"12-31-2018"]); //4 should be a valid date

        $this->setFakeData($ba1, [0=>"000000001",11=>"2018-04-11"]); //5 should validate and add asset
        $this->setFakeData($ba1, [0=>"000000002",11=>"2018-04-12"]); //6 should validate and add asset
        $ba1->process();
        // $ba1->debug();
        // $ba1->debug(true);
        $this->assertContains('does not match the format Y-m-d', $ba1->failed[0]['errors']->getMessages()[11][0]);
        $this->assertContains('does not match the format Y-m-d', $ba1->failed[1]['errors']->getMessages()[11][0]);
        $this->assertContains('does not match the format Y-m-d', $ba1->failed[2]['errors']->getMessages()[11][0]);
        $this->assertContains('does not match the format Y-m-d', $ba1->failed[3]['errors']->getMessages()[11][0]);
        $this->assertContains('does not match the format Y-m-d', $ba1->failed[4]['errors']->getMessages()[11][0]);

        $assets = \App\Asset::all();
        // dump($assets->toArray());

        $this->assertEquals('2018-04-11',$assets[0]->acquisition_date);
        $this->assertEquals('2018-04-12',$assets[1]->acquisition_date);

    }

    /** @test */
    public function it_validates_cost()
    {


        $dependencies = $this->createAssetDependencies();

        $ba1 = new BulkuploadAsset($this->getTemplateFile());
        $this->setFakeData($ba1, [0=>"000000001",12=>""]); //should create an asset
        $this->setFakeData($ba1, [0=>"000000002",12=>"$10.00"]); //should remove the $ and create an asset
        $this->setFakeData($ba1, [0=>"000000003",12=>"10.00"]); //should create an asset
        $this->setFakeData($ba1, [0=>"000000004",12=>"10"]); //should create an asset
        $this->setFakeData($ba1, [0=>"000000005",12=>"$1,000,000"]); //should remove $/commas and create an asset
        $ba1->process();
        // $ba1->debug();
        // $ba1->debug(true);


        $assets = \App\Asset::all();

        //fail
        $this->assertContains("required",$ba1->failed[0]['errors']->getMessages()[12][0]);

        //pass
        $this->assertEquals("10.00",$assets[0]->cost);
        $this->assertEquals("10.00",$assets[1]->cost);
        $this->assertEquals("10.00",$assets[2]->cost);
        $this->assertEquals("1000000.00",$assets[3]->cost);

    }

    /** @test */
    public function it_validates_po_number()
    {
        $dependencies = $this->createAssetDependencies();

        $ba1 = new BulkuploadAsset($this->getTemplateFile());
        $this->setFakeData($ba1, [0=>"000000001", 13=>'po-123']);
        $this->setFakeData($ba1, [0=>"000000002", 13=>'po-456']);

        $ba1->process();
        // $ba1->debug();

        $assets = \App\Asset::all();
        $this->assertEquals('po-123',$assets[0]->po_number);
        $this->assertEquals('po-456',$assets[1]->po_number);

    }

    /** @test */
    public function it_validates_org_code()
    {
        $dependencies = $this->createAssetDependencies();


        $ba1 = new BulkuploadAsset($this->getTemplateFile());
        $this->setFakeData($ba1, [0=>'000000001', 14=>'']); //0 required
        $this->setFakeData($ba1, [0=>'000000002', 14=>'123']); // should convert orgcode to department id

        $ba1->process();
        // $ba1->debug();
        // $ba1->debug(true);
        $assets = \App\Asset::all();
        // dump($assets->toArray());
        $this->assertEquals(1,$assets[0]->department_id);

        $this->assertContains("required", $ba1->failed[0]['errors']->getMessages()[14][0]);

    }

    /** @test */
    public function it_validates_label()
    {
        $dependencies = $this->createAssetDependencies();

        $ba1 = new BulkuploadAsset($this->getTemplateFile());
        $this->setFakeData($ba1, [15=>"baz"]);

        $ba1->process();
        // $ba1->debug();
        // $ba1->debug(true);

        $this->assertEquals("baz",$ba1->assets[0]->label);
    }

    /** @test */
    public function it_validates_description_notes()
    {
        $dependencies = $this->createAssetDependencies();

        $ba1 = new BulkuploadAsset($this->getTemplateFile());
        $this->setFakeData($ba1, [16=>"foobarbaz"]);

        $ba1->process();
        // $ba1->debug();
        // $ba1->debug(true);

        $this->assertEquals("foobarbaz",$ba1->assets[0]->description);

    }




}


