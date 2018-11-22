<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1', 'namespace' => 'Api\v1'], function () {
// Route::group(['prefix' => 'v1','namespace' => 'Api\v1'], function () {

    Route::get('asset', 'AssetController@index')->name('asset.index')->middleware('permission:asset.index');
    Route::post('asset', 'AssetController@store')->name('asset.store')->middleware('permission:asset.store');
    Route::get('asset/{asset}', 'AssetController@show')->name('asset.show')->middleware('permission:asset.show');
    Route::put('asset/{asset}', 'AssetController@update')->name('asset.update')->middleware('permission:asset.update');
    Route::delete('asset/{asset}', 'AssetController@destroy')->name('asset.destroy')->middleware('permission:asset.destroy');
    Route::post('asset/{id}/add-media', 'AssetController@addMedia')->name('asset.add-media')->middleware('permission:asset.add-media');
    Route::delete('asset/{id}/delete-media/{media_id}', 'AssetController@deleteMedia')->name('asset.delete-media')->middleware('permission:asset.delete-media');
    Route::post('asset/bulk-edit', 'AssetController@bulkEdit')->name('asset.bulk-edit');//->middleware('permission:asset.bulk-edit');

    Route::post('bulkupload/assets', 'BulkUploadController@assets')->name('bulkuploader.assets');//->middleware('permission:bulkuploader.assets');
    Route::post('bulkupload/locations', 'BulkUploadController@locations')->name('bulkuploader.locations');//->middleware('permission:bulkuploader.locations');

    Route::get('transfer', 'TransferController@index')->name('transfer.index');//->middleware('permission:transfer.index');
    Route::post('transfer', 'TransferController@store')->name('transfer.store');//->middleware('permission:transfer.store');
    Route::get('transfer/{id}/{field}', 'TransferController@show')->name('transfer.show');//->middleware('permission:transfer.show');
    Route::put('transfer/{transfer}', 'TransferController@update')->name('transfer.update');//->middleware('permission:transfer.update');
    Route::delete('transfer/{transfer}/{force?}', 'TransferController@destroy')->name('transfer.destroy');//->middleware('permission:transfer.destroy');

    Route::get('buildings', 'BuildingController@index')->name('buildings.index')->middleware('permission:buildings.index');
    Route::post('buildings', 'BuildingController@store')->name('buildings.store')->middleware('permission:buildings.store');
    Route::get('buildings/{building}', 'BuildingController@show')->name('buildings.show')->middleware('permission:buildings.show');
    Route::put('buildings/{building}', 'BuildingController@update')->name('buildings.update')->middleware('permission:buildings.update');
    Route::delete('buildings/{building}', 'BuildingController@destroy')->name('buildings.destroy')->middleware('permission:buildings.destroy');

    Route::get('campus', 'CampusController@index')->name('campus.index')->middleware('permission:campus.index');
    Route::post('campus', 'CampusController@store')->name('campus.store')->middleware('permission:campus.store');
    Route::get('campus/{campus}', 'CampusController@show')->name('campus.show')->middleware('permission:campus.show');
    Route::put('campus/{campus}', 'CampusController@update')->name('campus.update')->middleware('permission:campus.update');
    Route::delete('campus/{campus}', 'CampusController@destroy')->name('campus.destroy')->middleware('permission:campus.destroy');


    Route::get('category', 'CategoryController@index')->name('category.index')->middleware('permission:category.index');
    // Route::get('category/suggestions', 'CategoryController@suggestions'); -- on WEB routes

    Route::get('users', 'UserController@index')->name('users.index')->middleware('permission:users.index');
    Route::post('users', 'UserController@store')->name('users.store')->middleware('permission:users.store');
    Route::get('users/{user}', 'UserController@show')->name('users.show')->middleware('permission:users.show');
    Route::put('users/{user}', 'UserController@update')->name('users.update')->middleware('permission:users.update');
    Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy')->middleware('permission:users.destroy');
    Route::post('users/{user}/sync/departments', 'UserController@syncDepartments')->name('users.sync.departments')->middleware('permission:users.sync.departments');
    Route::post('users/{user}/sync/roles', 'UserController@syncRoles')->name('users.sync.roles')->middleware('permission:users.sync.roles');
    Route::get('currentuser', 'UserController@currentUser')->name('user.currentuser')->middleware('permission:user.currentuser');
    Route::get('currentuser/departments', 'UserController@departments')->name('user.currentuser-departments');//->middleware('permission:user.currentuser');

    Route::get('departments', 'DepartmentController@index')->name('departments.index')->middleware('permission:departments.index');
    Route::post('departments', 'DepartmentController@store')->name('departments.store')->middleware('permission:departments.store');
    Route::get('departments/{department}', 'DepartmentController@show')->name('departments.show')->middleware('permission:departments.show');
    Route::put('departments/{department}', 'DepartmentController@update')->name('departments.update')->middleware('permission:departments.update');
    Route::delete('departments/{department}', 'DepartmentController@destroy')->name('departments.destroy')->middleware('permission:departments.destroy');
    // Route::get('department/{id}/user/suggestions', 'Api\v1\DepartmentController@users'); -- on WEB routes
    // Route::get('department/{id}/rooms/suggestions', 'Api\v1\DepartmentController@rooms'); -- on WEB routes

    // Route::get('media', 'MediaController@index')->name('media.index')->middleware('permission:media.index');
    // Route::post('media', 'MediaController@store')->name('media.store')->middleware('permission:media.store');
    // Route::get('media/{building}', 'MediaController@show')->name('media.show')->middleware('permission:media.show');
    // Route::put('media/{building}', 'MediaController@update')->name('media.update')->middleware('permission:media.update');
    // Route::delete('media/{building}', 'MediaController@destroy')->name('media.destroy')->middleware('permission:media.destroy');

    Route::get('permissions', 'PermissionController@index')->name('permissions')->middleware('permission:permissions.index');
    Route::get('permissions/{permission}', 'PermissionController@show')->name('permissions.show')->middleware('permission:permissions.show');

    Route::get('properties', 'PropertiesController@index')->name('properties.index')->middleware('permission:properties.index');
    Route::post('properties', 'PropertiesController@store')->name('properties.store')->middleware('permission:properties.store');
    Route::delete('properties/{property}', 'PropertiesController@destroy')->name('properties.destroy')->middleware('permission:properties.destroy');
    // Route::get('properties/suggestions', 'PropertiesController@suggestions'); -- on WEB routes

    Route::get('roles', 'RoleController@index')->name('roles.index')->middleware('permission:roles.index');
    Route::get('roles/{role}', 'RoleController@show')->name('roles.show')->middleware('permission:roles.show');
    Route::post('roles/{role}/sync/permission', 'RoleController@syncPermission')->name('role.sync.permission')->middleware('permission:role.sync.permission');

    Route::get('rooms', 'RoomController@index')->name('rooms.index')->middleware('permission:rooms.index');
    Route::post('rooms', 'RoomController@store')->name('rooms.store')->middleware('permission:rooms.store');
    Route::put('rooms/{room}', 'RoomController@update')->name('rooms.update')->middleware('permission:rooms.update');
    Route::delete('rooms/{room}', 'RoomController@destroy')->name('rooms.destroy')->middleware('permission:rooms.destroy');
    Route::post('rooms/{room}/sync/departments', 'RoomController@syncDepartments')->name('rooms.sync.departments')->middleware('permission:rooms.sync.departments');
    Route::post('rooms/{room}/sync/supports', 'RoomController@syncSupports')->name('rooms.sync.supports')->middleware('permission:rooms.sync.supports');

    Route::post('rooms/{id}/add-media', 'RoomController@addMedia')->name('rooms.add-media')->middleware('permission:rooms.add-media');
    Route::delete('rooms/{id}/delete-media/{media_id}', 'RoomController@deleteMedia')->name('rooms.delete-media')->middleware('permission:rooms.delete-media');

    Route::get('roomstyle', 'RoomStyleController@index')->name('roomstyle.index')->middleware('permission:roomstyle.index');
    Route::post('roomstyle', 'RoomStyleController@store')->name('roomstyle.store')->middleware('permission:roomstyle.store');

    Route::get('software', 'SoftwareController@index')->name('software.index')->middleware('permission:software.index');
    Route::post('software', 'SoftwareController@store')->name('software.store')->middleware('permission:software.store');
    Route::get('software/{software}', 'SoftwareController@show')->name('software.show')->middleware('permission:software.show');
    Route::put('software/{software}', 'SoftwareController@update')->name('software.update')->middleware('permission:software.update');
    Route::delete('software/{software}', 'SoftwareController@destroy')->name('software.destroy')->middleware('permission:software.destroy');

    // Route::get('inventory', 'UserController@currentUser');

});
