<?php

namespace App\Http\Controllers\Api\v1;

use App\Transfer;
use App\Asset;
use App\Department;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Http\JsonResponse;
use App\Mail\TransferRequest;



class TransferController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Helper\RestSearch::all(Transfer::class);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'asset_ids' => 'required',
            'new_department_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->messages(), 422);
        }

        $assetIds = $request->all()['asset_ids'];
        $transfers = [];
        // return $request->all()['new_department_id'];
        foreach ($assetIds as $value) {

            $asset = Asset::find($value);
            $asset->media;
            $transferData = [
                'asset_id' => $value,
                'old_department_id' => $asset->department_id,
                'new_department_id' => $request->all()['new_department_id'],
                'status' => $request->all()['status'],
            ];



            $transfer = Transfer::updateOrCreate(['asset_id'=>$value],$transferData);

            $transfer['asset'] = $asset;
            $transfer['old_department'] = Department::find($transferData['old_department_id']);
            $transfer['new_department'] = Department::find($transferData['new_department_id']);

            array_push($transfers, $transfer);
        }

        //group by newDepartment and email all new transfers to each department
        $transfers = collect($transfers);
        $email = $transfers->first()->new_department->email;
        // return $transfers;
        // return $email;
        \Mail::to($email)->send(new TransferRequest($transfers));


        return $transfers;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $transfer = Transfer::findOrFail($id);
        $name = $request->get('name');
        $value = $request->get('value');
        $transfer->$name = $value;
        $transfer->save();

        return $transfer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id, $force=false)
    {
        $transfer = Transfer::findOrFail($id);
        if ($force) {
            $transfer->forceDelete();
        } else {
            $transfer->delete();
        }
        return $transfer;
    }
}
