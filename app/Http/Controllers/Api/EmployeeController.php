<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::latest()->get();
        return response()->json($employee);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name'         => 'required',
            'email'        => 'required|unique:employees',
            'phone'        => 'required',
            'address'      => 'required',
            'salary'       => 'required',
            'joining_date' => 'required',
        ]);

        if ($request->photo) {
            $position    = strpos($request->photo, ';');
            $sub         = substr($request->photo, 0, $position);
            $ext         = explode('/', $sub)[1];
            $name        = time() . '.' . $ext;
            $img         = Image::make($request->photo)->resize(240, 200);
            $upload_path = 'uploads/backend/employee/';
            $image_url   = $upload_path . $name;
            $img->save($image_url);

            Employee::insert([
                'name'         => $request->name,
                'email'        => $request->email,
                'phone'        => $request->phone,
                'address'      => $request->address,
                'salary'       => $request->salary,
                'nid'          => $request->nid,
                'photo'        => $image_url,
                'joining_date' => $request->joining_date,
                'created_at'   => Carbon::now(),
            ]);
        } else {
            Employee::insert([
                'name'         => $request->name,
                'email'        => $request->email,
                'phone'        => $request->phone,
                'address'      => $request->address,
                'salary'       => $request->salary,
                'nid'          => $request->nid,
                'joining_date' => $request->joining_date,
                'created_at'   => Carbon::now(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::where('id', $id)->first();
        return response()->json($employee);
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
        $data = array();
        $data['name']         = $request->name;
        $data['email']        = $request->email;
        $data['phone']        = $request->phone;
        $data['salary']       = $request->salary;
        $data['nid']          = $request->nid;
        $data['joining_date'] = $request->joining_date;
        $image = $request->new_photo;
        if ($image) {
            $position    = strpos($image, ';');
            $sub         = substr($image, 0, $position);
            $ext         = explode('/', $sub)[1];
            $name        = time() . '.' . $ext;
            $img         = Image::make($image)->resize(240, 200);
            $upload_path = 'uploads/backend/employee/';
            $image_url   = $upload_path . $name;
            $success     = $img->save($image_url);
            if ($success) {
                $data['photo'] = $image_url;
                $img           = DB::table('employees')->where('id', $id)->first();
                $image_path    = $img->photo;
                $done          = unlink($image_path);
                $user          = DB::table('employees')->where('id', $id)->update($data);
            }
        } else {
            $oldphoto      = $request->photo;
            $data['photo'] = $oldphoto;
            $user          = DB::table('employees')->where('id', $id)->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::where('id', $id)->first();
        $photo = $employee->photo;
        if ($photo) {
            unlink($photo);
        }
        Employee::where('id', $id)->delete();
    }
}
