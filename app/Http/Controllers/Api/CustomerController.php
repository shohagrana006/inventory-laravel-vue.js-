<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Customer::latest()->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'unique:customers',
            'address' => 'required',
        ]);
        if ($request->photo) {
            $position    = strpos($request->photo, ';');
            $sub         = substr($request->photo, 0, $position);
            $ext         = explode('/', $sub)[1];
            $name        = time() . '.' . $ext;
            $img         = Image::make($request->photo)->resize(240, 200);
            $upload_path = 'uploads/backend/customer/';
            $image_url   = $upload_path . $name;
            $img->save($image_url);

            Customer::insert([
                'name'         => $request->name,
                'phone'        => $request->phone,
                'email'        => $request->email,
                'address'      => $request->address,
                'photo'        => $image_url,
                'created_at'   => Carbon::now(),
            ]);
        } else {
            Customer::insert([
                'name'         => $request->name,
                'phone'        => $request->phone,
                'email'        => $request->email,
                'address'      => $request->address,
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
        $customer = Customer::where('id', $id)->first();
        return response()->json($customer);
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
        $data['phone']        = $request->phone;
        $data['email']        = $request->email;
        $data['address']      = $request->address;
        $image = $request->new_photo;
        if ($image) {
            $position    = strpos($image, ';');
            $sub         = substr($image, 0, $position);
            $ext         = explode('/', $sub)[1];
            $name        = time() . '.' . $ext;
            $img         = Image::make($image)->resize(240, 200);
            $upload_path = 'uploads/backend/customer/';
            $image_url   = $upload_path . $name;
            $success     = $img->save($image_url);
            if ($success) {
                $data['photo'] = $image_url;
                $img           = DB::table('customers')->where('id', $id)->first();
                $image_path    = $img->photo;
                $done          = unlink($image_path);
                $user          = DB::table('customers')->where('id', $id)->update($data);
            }
        } else {
            $oldphoto      = $request->photo;
            $data['photo'] = $oldphoto;
            $user          = DB::table('customers')->where('id', $id)->update($data);
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
        $customer = Customer::where('id', $id)->first();
        $photo = $customer->photo;
        if ($photo) {
            unlink($photo);
        }
        $customer->delete();
    }
}
