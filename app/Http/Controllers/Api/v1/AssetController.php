<?php

namespace App\Http\Controllers\Api\v1;

use App\Asset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;
use Image;
use Illuminate\Support\Facades\Storage;

class AssetController extends ApiController
{
    public function __construct() { }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */

    /**
     * @SWG\Get(
     *     path="/api/v1/assets",
     *     summary="get all Assets",
     *     tags={"Asset"},
     *     description="Muliple tags can be provided with comma separated strings. Use tag1, tag2, tag3 for testing.",
     *     operationId="findPetsByTags",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="tags",
     *         in="query",
     *         description="Tags to filter by",
     *         required=true,
     *         type="array",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid tag value",
     *     ),
     *     security={
     *         {
     *             "petstore_auth": {"write:pets", "read:pets"}
     *         }
     *     },
     *     deprecated=false
     * )
     */
    public function index()
    {
        return \App\Helper\RestSearch::all(Asset::class);
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
            'label' => 'required',
            'user_id' => 'required',
            'cost' => 'required',
            'room_id' => 'required',
            'department_id' => 'required'
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->messages(), 422);
        }

        $asset = Asset::create($request->all());
        $asset->media;
        $asset->users;
        $asset->department;
        $asset->room;
        $asset->room->building;
        $asset->room->building->campus;
        $asset->checkout;
        $asset->category;
        $asset->properties;

        return $asset;
    }

    public function addMedia(Request $request, $id)
    {
        $asset = Asset::find($id);

        $path =  storage_path( 'app/public/media/assets/' );

        //does directory exsits
        if(!file_exists($path) && !is_dir($path)){
            mkdir($path, 0777, true);
        }


        //store media
        $file = $request->media;
        $fileName = time() .'-'. $file->getClientOriginalName();
        $filepath = $path . $fileName;


        $img = Image::make($file)
            ->resize(null, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpeg')
            ->save($filepath);

        // return $img;
        // $media = Image::make($file->getRealPath())->fit(200, 112)->encode('png');
        // $path = Storage::putFile($media, $file->getClientOriginalName());


        //create media poloymorphic relation
        $count = $asset->media()->where('mediable_id', '=', $id)->count();

        if($count > 0){
            $asset
            ->media()
            ->update([
                'name'=>$file->getClientOriginalName(),
                'path'=>'/storage/media/assets/'.$fileName,
            ]);
        }else{
            $asset
            ->media()
            ->create([
                'name'=>$file->getClientOriginalName(),
                'path'=>'/storage/media/assets/'.$fileName,
            ]);
        }


        ;
        $asset->media;
        $asset->users;
        $asset->room;
        $asset->room->building;
        $asset->room->building->campus;
        $asset->checkout;
        $asset->category;
        $asset->properties;

        return $asset;

    }

    public function deleteMedia(Request $request, $id, $media_id)
    {
        $asset = Asset::find($id);
        $asset->media()->where('id', '=', $media_id)->delete();
        return $asset;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //if auditor only allow certain field to save

        $asset = Asset::findOrFail($id);
        $name = $request->get('name');
        $value = $request->get('value');
        $asset->$name = $value;
        $asset->save();


        $asset->media;
        $asset->users;
        $asset->room;
        $asset->room->building;
        $asset->room->building->campus;
        $asset->checkout;
        $asset->category;
        $asset->properties;

        return $asset;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id, $force=false)
    {

        // return $id;
        $asset = Asset::findOrFail($id);
        if ($force) {
            $asset->forceDelete();
        } else {
            $asset->delete();
        }
        return $asset;
    }



    /**************************
    Not Ready!!!
    Todo: Bulk Upload need permissions assigned
    Todo: Add to Routes
    **************************/


    /**
     * Remove a list resource from storage.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request, $ids)
    {
        $asset = Asset::findOrFail($id);
        $asset->forceDelete();
        return $asset;
    }


    /**
     * Bulk Edit A Array of IDs and Fields
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulkEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'asset_ids' => 'required',
            'fields' => 'required'
        ]);
        // dump($request->all());
        $assetIds = $request->all()['asset_ids'];
        $fields = $request->all()['fields'];

        // return ["assetIds"=>$assetIds,"fields"=>$fields];

        $assets = [];

        // for each asset id
        foreach ($assetIds as $asset_id) {

            $asset = Asset::find($asset_id);

            foreach ($fields as $name => $value) {
                if ($name == 'acquisition_date_temp') {
                    continue;
                }
                if ($value == null) {
                    continue;
                }

                $asset->$name = $value;
                $asset->save();

                $asset->media;
                $asset->users;
                $asset->department;
                $asset->room;
                $asset->room->building;
                $asset->room->building->campus;
                $asset->checkout;
                $asset->category;
                $asset->properties;
                array_push($assets, $asset);
            }


        }

        return $assets;
    }

}
