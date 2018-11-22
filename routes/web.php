<?php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', 'HomeController@index');
Route::get('/info', function(){
    phpinfo();
});
// Route::get('/home', 'HomeController@index');
Route::get('/user', function(){
    $user = Auth::user();
    dd(Auth::user()->can('create_asset'));
});



Route::get('/login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@login'] )->middleware('saml');
Route::get('/logout', [ 'as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::post('/saml-response', 'Auth\LoginController@saml');

Route::domain('dev.wits.weber.edu')->group(function () {
    Route::get('/browserSync/login/{user}', function ($user) {
        $user = \App\User::where('username', $user) -> first();
        Auth::login($user, true);
        return redirect('/app');
    });
});


Route::get('category/suggestions', 'Api\v1\CategoryController@suggestions');
Route::get('properties/suggestions', 'Api\v1\PropertiesController@suggestions');
Route::get('department/{id}/user/suggestions', 'Api\v1\DepartmentController@users');
Route::get('department/{id}/rooms/suggestions', 'Api\v1\DepartmentController@rooms');




Route::group(['middleware' => 'auth'], function () {

    Route::get('/app/history', function () {

        $assets = App\Asset::all();

        foreach ($assets as $asset) {
            $asset->revisionHistory;
        }
        return $assets;
    });

    Route::get('/app/{vue?}', function () {
        return view('vue');
    })->where('vue', '[\/\w\.-]*');


});


Route::get('/install', function () {
    Artisan::call('db:make');

    echo 'DB Migration, DONE... ';
    sleep(2);
    return redirect('/');
});
