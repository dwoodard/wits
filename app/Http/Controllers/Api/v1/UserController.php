<?php

namespace App\Http\Controllers\Api\v1;

use App\User;
use Validator;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DB;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Helper\RestSearch::all(User::class);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->messages(), 422);
        }

        $user = User::create($request->all() + ['password' => bcrypt('password')] );

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $with = !empty($request->query('with')) ? explode(',', $request->query('with')) : [];
        $fields = !empty($request->query('fields')) ? explode(',',$request->query('fields')) : null;

        return User::with($with)->find($id, $fields);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }


    public function syncDepartments(Request $request, User $user)
    {
        $data = collect($request->all());
        // return $request->all();
        $ids = $user->departments()->sync($data->pluck('id'));
        $departments['attached'] = \App\Department::find($ids["attached"]);
        $departments['detached'] = \App\Department::find($ids["detached"]);
        $departments['updated'] = \App\Department::find($ids["updated"]);
        return $departments;
    }

    public function syncRoles(Request $request, User $user)
    {
        $data = collect($request->all());
        // return $data->pluck('name');
        $ids = $user->syncRoles($data->pluck('name'));

        return $user->roles()->pluck('name');
    }

    public function currentUser(Request $request)
    {
        try {
            $id =  auth()->guard('api')->user()->id;
        } catch (Exception $e) {
             abort(422, $e->getMessage());
        }

        $currentusers = collect(\App\Helper\RestSearch::all(\App\User::class));

        $currentuser = $currentusers->filter(
            function($user) use ($id){return $user->id == $id;}
        )->first();

        return collect([
            "currentuser" => $currentuser
        ]);
    }

    public function departments()
    {
        // $user = Auth::loginUsingId(26);

        $departments_ids = collect([]);
        $user = Auth::user();
        $user->departments;
        $user->roles;

        foreach ($user->departments as $department) {
            $currentuserDepartmentId = $department->id;
            $departments_ids->push($department->id);

            $departments = DB::select("select id, parent_department_id
            from (select * from departments order by parent_department_id, id)
            children_departments,
            (select @pv := $currentuserDepartmentId) initialisation where
            find_in_set(parent_department_id, @pv)
            and length(@pv := concat(@pv, ',', id))");

            $departments_ids->push(collect($departments)->pluck('id')->prepend($user->departments[0]->id));

        }




        $data = collect([
            'departments_ids' => $departments_ids->flatten()->unique()->values(),
            'currentUser' => $user
            ]);
        return $data;
    }

    public function suggestions(Request $request)
    {
        return \App\Helper\RestSearch::all(User::class);
    }

}
