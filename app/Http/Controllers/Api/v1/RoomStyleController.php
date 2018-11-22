<?php

namespace App\Http\Controllers\Api\v1;

use App\RoomStyle;
use Illuminate\Http\Request;
use Validator;


class RoomStyleController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Helper\RestSearch::all(RoomStyle::class);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'name' => 'required|unique:campus',
        'campus_code' => 'required|unique:campus',
        ]);
        $campus = Room::create($request->all());
        return Room::with('buildings', 'buildings.rooms')->find($campus->id);


    }

}
