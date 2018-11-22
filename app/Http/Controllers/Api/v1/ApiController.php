<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ApiController
 *
 * @package App\Http\Controllers
 *
 * @SWG\Swagger(
 *     basePath="",
 *     host="localhost",
 *     schemes={"http"},
 *     @SWG\Info(
 *         version="1.0",
 *         title="WITS API",
  *     ),
 *     @SWG\Definition(
 *         definition="Error",
 *         required={"code", "message"},
 *         @SWG\Property(
 *             property="code",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         )
 *     )
 * )
 */
ABSTRACT class ApiController extends Controller
{
    // function __construct(){//check permissions }

    /*
    permision naming convention
    ModelController::function
    __METHOD__
    "App\Http\Controllers\Api\v1\AssetController::index"
    AssetController::index => asset.index

    asset.index is what to call the permission name
    */
    // function hasPermission($permission){
    //     $perm = [];
    //     preg_match("/(\w+)Controller::(\w+)/i", $permission, $perm);
    //     $permission = strtolower($perm[1]) .".". $perm[2];
    //     $this->middleware([ "permission:$permission" ]);
    // }
}
