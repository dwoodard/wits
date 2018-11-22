<?php

namespace App\Http\Controllers\Api\v1;

use App\Room;
use Illuminate\Http\Request;
use Validator;
use Image;

class RoomController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Helper\RestSearch::all(Room::class);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return ($request->all());

        $this->validate($request, [
        'name' => '',
        'number' => '',
        'building_id' => 'required'
        ]);

        $room = Room::create($request->all());
        $room->software = [];
        return $room;

    }

    public function addMedia(Request $request, $id)
    {
        $room = Room::find($id);

        $path =  storage_path( 'app/public/media/rooms/' );

        //does directory exsits
        if(!file_exists($path) && !is_dir($path)){
            mkdir($path, 0777, true);
        }


        //store media
        $file = $request->media;
        $fileName = time() .'-'. $file->getClientOriginalName();
        $filepath = $path . $fileName;


        $img = Image::make($file)
            ->fit(600, 337)
            ->encode('jpeg')
            ->save($filepath);

        return $room
            ->media()
            ->create([
                'name'=>$file->getClientOriginalName(),
                'path'=>'/storage/media/rooms/'.$fileName,
            ]);
        ;

        return $room;

    }

    public function deleteMedia(Request $request, $id, $media_id)
    {
        $room = Room::find($id);
        $room->media()->where('id', '=', $media_id)->delete();
        return $room;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $this->validate($request, [
        'name' => '',
        'number' => '',
        'building_id' => ''
        ]);

        $room = Room::find($room->id);
        $room->fill($request->all());

        $room->save();
        return $room;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room = Room::findOrFail($room->id);
        $room->delete();
        return $room;
    }


    public function syncDepartments(Request $request, Room $room)
    {
        $data = collect($request->all());
        // return $data->pluck('id');
        $ids = $room->departments()->sync($data->pluck('id'));
        $departments['attached'] = \App\Department::find($ids["attached"]);
        $departments['detached'] = \App\Department::find($ids["detached"]);
        $departments['updated'] = \App\Department::find($ids["updated"]);
        return $departments;
    }

    public function syncSupports(Request $request, Room $room)
    {
        $data = collect($request->all());
        // return $data->pluck('id');
        $ids = $room->supports()->sync($data->pluck('id'));
        $supports['attached'] = \App\User::find($ids["attached"]);
        $supports['detached'] = \App\User::find($ids["detached"]);
        $supports['updated'] = \App\User::find($ids["updated"]);
        return $supports;
    }
}
