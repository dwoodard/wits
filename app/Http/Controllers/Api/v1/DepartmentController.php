<?php

namespace App\Http\Controllers\Api\v1;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Laravel\Passport\HasApiTokens;
use DB;
class DepartmentController extends ApiController
{

    use HasApiTokens, DispatchesJobs, ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */


    public function index()
    {
         return \App\Helper\RestSearch::all(Department::class);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validate = $this->validate($request, [
        'name' => 'required',
        'primary_contact_name' => 'required',
        'orgcode' => 'required|unique:departments,orgcode',
        'phone' => 'nullable',
        'email' => 'nullable|email',
        'parent_department_id' => 'nullable|numeric',
        ]);

        // return $request->all();
        $department = Department::create($request->all());
        $department->org = [];

        $parent = Department::find($request->get('parent_department_id'));

        $department->parent = $parent;
        return $department;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $with = !empty($request->query('with')) ? explode(',', $request->query('with')) : [];
        $fields = !empty($request->query('fields')) ? explode(',',$request->query('fields')) : null;

        return Department::with($with)->find($id, $fields);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $validate = $this->validate($request, [
        'name' => 'required',
        'primary_contact_name' => 'required',
        'phone' => 'nullable',
        'orgcode' => 'required|unique:departments,orgcode,'.$department->id,
        'email' => 'nullable|email',
        'parent_department_id' => 'nullable|numeric',
        ]);

        $department = Department::find($department->id);
        $department->fill($request->all());

        $department->save();
        return $department;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department = Department::find($department->id);
        $department->delete();
        return $department;

    }

    public function users($id)
    {
        return DB::select('Select users.id as value, concat(users.first_name, " ", users.last_name ) as text from users LEFT JOIN department_user ON users.id = department_user.user_id where department_id = ' . $id);
    }

    public function rooms($id)
    {
        $department = Department::find($id);
        $rooms = $department->rooms;
        foreach ($rooms as $room) {
            $room->building;
        }
        return $department->rooms;
    }

}
