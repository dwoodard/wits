<?php
namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use League\Csv\Reader;
use App\Bulkupload\BulkUploadAsset;

class BulkUploadController extends ApiController
{
    public function __construct() { }

    public function assets(Request $request)
    {
        $file = $request->file('upload');
        $bulkuploadAsset = new BulkUploadAsset($file);

        $bulkuploadAsset->process();
        // $bulkuploadAsset->debug();
        // $bulkuploadAsset->debug(true);

        
        return collect([
            'assets' =>  $bulkuploadAsset->assets,
            'csv'    =>  $bulkuploadAsset->csv,
            'failed' =>  $bulkuploadAsset->failed,
            'headers'=>  $bulkuploadAsset->headers,
            'debug'  =>  $bulkuploadAsset->debug,
        ]);
    }


    public function locations(Request $request)
    {
        $csv = Reader::createFromPath($request->file('upload'), 'r');
        return $csv;
    }
}
