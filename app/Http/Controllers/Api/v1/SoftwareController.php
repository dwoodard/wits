<?php

namespace App\Http\Controllers\Api\v1;

use App\Software;
use Illuminate\Http\Request;

class SoftwareController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
            return \App\Helper\RestSearch::all(Software::class);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $software = Software::create($request->all());

        $software->room()->attach($request->room_id);

        return $software;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Software $software)
    {
        $software = Software::find($software->id);
        $software->fill($request->all());

        $software->save();
        return $software;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Software $software)
    {
        $software = Software::find($software->id);
        $software->fill($request->all());

        $software->save();
        return $software;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function destroy(Software $software)
    {
         $software = Software::find($software->id);
         return $software;
    }
}
