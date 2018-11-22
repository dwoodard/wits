<?php

namespace App\Http\Controllers\Api\v1;

use App\Properties;
use Illuminate\Http\Request;
use Validator;
use DB;

class PropertiesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Helper\RestSearch::all(Properties::class);
    }

     

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Properties $properties)
    {
        $rules = array(
            'id' => '',
            'asset_id' => 'required',
            'name' => 'required',
            'value' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return json_encode($validator->errors());
        } else {
            // store
            return $properties->updateOrCreate(['id' => $request->id], $request->all());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Properties  $properties
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id, Properties $properties)
    {
        return Properties::destroy($id);
    }

    public function suggestions(Request $request)
    {
        return DB::table('properties')->select('name')->distinct()->get();
    }
}
