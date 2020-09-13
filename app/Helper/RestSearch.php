<?php

namespace App\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
*
*/
class RestSearch
{
        //search usage - api/v1/users?search=de
        //with usage - api/v1/users?with=model1,model2
        //search columns usage - api/v1/asset?searchColumns=name,model,manufacturer&search=lap
        //fields usage - api/v1/users?fields=email,id,username
        //wherein - api/v1/users?wherein=department,1,2,3
        //all usages - api/v1/users?search=de&fields=email,id,username&with=model1,model2


        //https://localhost:3000/asset?wherein=department_id,1,2,3&with=media,department,room,room.roomstyle,room.building,room.building.campus,checkout,category,properties,users
        public static function all($model)
        {
            if (request()->query('search')) {
                $search = explode(',', request()->query('search'));
            } else {
                $search = null;
            }
            $searchColumns = !empty(request()->query('searchColumns')) ? explode(',', request()->query('searchColumns')) : [];
            $with = !empty(request()->query('with')) ? explode(',', request()->query('with')) : [];
            $fields = !empty(request()->query('fields')) ? explode(',',request()->query('fields')) : null;

            $wherein = !empty(request()->query('wherein')) ? explode(',', request()->query('wherein')) : null;
            $whereinField = is_array($wherein) ?  array_shift($wherein) : null;

            // dump($search);
            // dump($searchColumns);
            // dump($with);
            // dump($fields);
            // dump($wherein);
            // dump($whereinField);


            return $model::orWhere(function ($query) use ($searchColumns, $search, $wherein, $whereinField )
            {
                // dump($searchColumns, $search);
                foreach ($searchColumns as $key => $value) {
                    $query->orWhere($value, 'LIKE', "%$search[0]%");
                }


                // dump($whereinField, $whereinField);
                if ($wherein) {
                    $query->whereIn($whereinField, $wherein);
                }


            })
            ->with($with)
            ->get($fields)
            ;
        }

        public static function find($model)
        {
            $id = !empty(request()->query('id')) ? explode(',', request()->query('id')) : null;
            $search = !empty(request()->query('search')) ? explode(',', request()->query('search')) : null;
            $searchColumns = !empty(request()->query('searchColumns')) ? explode(',', request()->query('searchColumns')) : [];
            $with = !empty(request()->query('with')) ? explode(',', request()->query('with')) : [];
            $fields = !empty(request()->query('fields')) ? explode(',',request()->query('fields')) : null;

            return $model::find($id)->orWhere(function ($query) use ($searchColumns, $search) {
                // dump($searchColumns, $search);
                foreach ($searchColumns as $key => $value) {
                    // dump($key, $value);
                    $query->orWhere($value, 'LIKE', "%$search[0]%");
                }

            })
            ->with($with)
            ->get($fields);

            return User::with($with)->find($id, $fields);
        }

}
