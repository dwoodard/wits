<?php

namespace App\Http\Controllers\Api\v1;

use App\Category;
use Illuminate\Http\Request;
use DB;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Helper\RestSearch::all(Category::class);
    }



    public function suggestions(Request $request)
    {
        return DB::select("SELECT id AS value, CONCAT('id: ', id, ' - ', name, ' - ', lifecycle, ' years' ) as text FROM category");
    }
}
