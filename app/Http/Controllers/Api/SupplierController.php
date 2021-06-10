<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::latest()->get();
        return response()->json($supplier);
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
            'name'    => 'required',
            'email'   => 'required|unique:suppliers',
            'phone'   => 'required',
            'address' => 'required',
        ]);

        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub      = substr($request->photo, 0, $position);
            $ext      = explode('/', $sub)[1];
            $name     = time() . '.' . $ext;
            $img      = Image::make($request->photo)->resize(240, 200);
            $path     = 'uploads/backend/supplier/';
            $img_url  = $path . $name;
            $img->save($img_url);

            Supplier::insert([
                'name'      => $request->name,
                'email'     => $request->email,
                'phone'     => $request->phone,
                'address'   => $request->address,
                'shopname'  => $request->shopname,
                'photo'     => $img_url,
                'created_at' => Carbon::now(),
            ]);
        } else {
            Supplier::insert([
                'name'      => $request->name,
                'email'     => $request->email,
                'phone'     => $request->phone,
                'address'   => $request->address,
                'shopname'  => $request->shopname,
                'created_at' => Carbon::now(),
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
        $supplier = Supplier::where('id', $id)->first();
        return response()->json($supplier);
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
        $data['address']      = $request->address;
        $data['shopname']     = $request->shopname;
        $image = $request->newphoto;
        if ($image) {
            $position    = strpos($image, ';');
            $sub         = substr($image, 0, $position);
            $ext         = explode('/', $sub)[1];
            $name        = time() . '.' . $ext;
            $img         = Image::make($image)->resize(240, 200);
            $upload_path = 'uploads/backend/supplier/';
            $image_url   = $upload_path . $name;
            $success     = $img->save($image_url);
            if ($success) {
                $data['photo'] = $image_url;
                $img           = DB::table('suppliers')->where('id', $id)->first();
                $image_path    = $img->photo;
                $done          = unlink($image_path);
                $user          = DB::table('suppliers')->where('id', $id)->update($data);
            }
        } else {
            $oldphoto      = $request->photo;
            $data['photo'] = $oldphoto;
            $user          = DB::table('suppliers')->where('id', $id)->update($data);
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
        $supplier = Supplier::where('id', $id)->first();
        if ($supplier->photo) {
            unlink($supplier->photo);
        }
        Supplier::where('id', $id)->delete();
    }
}
