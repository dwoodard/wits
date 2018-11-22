<?php

namespace App\Bulkupload;

use App\Asset;
use App\User;
use App\Building;
use App\Department;
use League\Csv\Reader;
use Exception;
use Illuminate\Http\UploadedFile;
use Validator;
use Illuminate\Support\MessageBag as MessageBag;
use Carbon\Carbon;


class BulkUploadAsset
{
    private $file;
    private $csv;
    private $headers;
    private $exampleInserts;
    public $debug;

    private $assets;

    private $failed;
    // private $errors;

    public function __construct($file)
    {
        if(empty($file)){
            throw new Exception("File can't be empty", 1);
        }

        if(!($file instanceof UploadedFile)){
            throw new Exception("File is not an instanceof UploadedFile", 1);
        }

        // $this->debug = false;
        $this->file = $file;
        $this->csv = collect(Reader::createFromPath($file, 'r'));
        $this->assets = collect();
        $this->failed = collect();

        $this->headers = collect($this->csv->shift());

        $this->headers->each(function($header, $key){
           $this->headers[$key] = preg_replace('/[ \t*]+$/', '', $this->headers[$key]); //remove trailing space and stars
        });

        $this->exampleInserts = $this->csv->shift();

        // $this->process();
    }

    public function process()
    {
        $this->csv->each(function ($row, $key){
            $passed = $this->validate($row,$key);

            if ($passed) {
                $this->save($row, $key);
            }

        });
    }

    public function debug($assets=false)
    {

        dump('Total Rows: ' . $this->csv->count()  . ' / Failed: ' .  $this->failed->count() . ' / Assets Created: ' . $this->assets->count());
        if (!$assets) {
            dump($this->failed);
        }else{
            dump($this->assets->toArray());
        }

        $this->failed->each(function($item,$key){
            // dump($item['row']);
        });
    }

    public function validate($row, $key) {
        $customMessages = [
            // 'required' => "The :attribute field can not be blank."
        ];

            if($row[0] == ''){
                $row[0] = NULL;
            }

            $validator = Validator::make($row, [
                0  => [ "nullable", "regex:/^[wWsS0-9^-]{4,9}$/", "unique:assets,weber_inventory_tag"],     // 0  "weber_inventory_tag *"
                1  => "nullable|alpha",                                                                                          // 1  "category"
                2  => "required",                                                                                                // 2  "manufacturer **"
                3  => "",                                                                                                        // 3  "vendor **"
                4  => "",                                                                                                // 4  "model *"
                5  => "regex:/([0-9a-fA-F]{2}[:-]){5}([0-9a-fA-F]{2})/",                                                         // 5  "wired_mac_address **"
                6  => "regex:/([0-9a-fA-F]{2}[:-]){5}([0-9a-fA-F]{2})/",                                                         // 6  "wireless_mac_address **"
                7  => "",                                                                                                // 7  "serial_number *"
                8  => "required",                                                                                                // 8  "username *"
                9  => "required",                                                                                                // 9  "building_code *"
                10 => "required",                                                                                                // 10 "room_id *"
                11 => "date_format:Y-m-d",                                                                                       // 11 "acquisition_date"
                12 => "required",                                                                                                // 12 "cost"
                13 => "",                                                                                                        // 13 "po_number"
                14 => "required",                                                                                                // 14 "org_code *"
                15 => "",                                                                                                        // 15 "label"
                16 => "",                                                                                                        // 16 "description_notes"
            ],$customMessages, $this->headers->toArray());

            if ($validator->fails()) {
                $this->failed->push([
                    'row_id' => $key,
                    'row' => $row,
                    'type' => 'validate',
                    'errors' => $validator->errors()
                ]);
            }
           return $validator->passes();

    }

    public function save($row, $key) {
            $cost = preg_replace('/[\$ ,]/', '', $row[12]);

            $asset = new \App\Asset;
            try {


                if($row[0] == ''){$row[0] = NULL; }

                $asset->weber_inventory_tag = $row[0];
                $asset->manufacturer = $row[2];
                $asset->vendor = $row[3];
                $asset->model = $row[4];
                $asset->serial_number = $row[7];
                $asset->acquisition_date = (new Carbon($row[11]))->format('Y-m-d');
                $asset->cost =  $cost == null ? null : number_format( $cost , 2, '.', '');
                $asset->po_number = $row[13];
                $asset->label = $row[15];
                $asset->description = $row[16];

                $asset->category = $row[1];
                $asset->room_id = $this->convertRoomToId($row[9],$row[10]);
                $asset->user_id = $this->convertUsernameToId($row[8]);
                $asset->department_id = $this->convertOrgcodeToId($row[14]);

                $asset->save();


                $asset->media;
                $asset->users;
                $asset->room;
                $asset->room->building;
                $asset->room->building->campus;
                $asset->checkout;
                $asset->category;
                $asset->properties;

                $this->assets->push($asset);
            }
            catch (Exception $e) {
                $this->failed->push([
                    'row_id' => $key,
                    'row' => $row,
                    'type' => 'save',
                    'errors' => new MessageBag(collect($e->getMessage())->toArray() )
                ]);
            }

            if ($asset->id) {

                // wired_mac_address
                if($row[5]){
                    $asset->properties()->create([
                        'name'=>'wired_mac_address',
                        'asset_id'=>$asset->id,
                        'value'=> $row[5]
                    ]);
                }

                // wireless_mac_address
                if($row[6]){
                    $asset->properties()->create([
                        'name'=>'wireless_mac_address',
                        'asset_id'=>$asset->id,
                        'value'=> $row[6]
                    ]);
                }

            }

    }

    public function convertCategoryToId($category) {
        // dump($category);
        if(empty($category)){
            return;
        }

        $category = \App\Category::where('name', strtolower($category))->get()->first();
        // dump($category);
        if($category && $category->id){
            return $category->id;
        }
    }

    public function convertRoomToId($building_code,$room) {
        $building_code = strtolower($building_code);

        // dump($building_code,$room);

        // tolowercase
        $building = \App\Building::where('code', $building_code)->get()->first();

        if($building){
            // dump($building->id);

            $room = \App\Room::where([ 'building_id' => $building->id, 'number'=> $room])->get()->first();
            // dump($room);
            return $room->id;


        }else{
            throw new Exception("Building Not found in Database: ". $building_code , 1);
        }




    }

    public function convertUsernameToId($username) {
        // dump($username);

        $user = \App\User::where('username', $username)->get()->first();

        if($user){
            return $user->id;
        }else{
            throw new Exception("User Not found: ". $username , 1);
        }

    }

    public function convertOrgcodeToId($org_code) {
        $department = \App\Department::where('orgcode', $org_code)->get()->first();
        // dump($department);
        return $department->id;
    }



    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }

}
