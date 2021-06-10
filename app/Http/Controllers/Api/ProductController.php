<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Product;
use Carbon\Carbon;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $product = DB::table('products')
            ->join('categories', 'products.category_id', 'categories.id')
            ->join('suppliers', 'products.supplier_id', 'suppliers.id')
            ->select('categories.category_name', 'suppliers.name', 'products.*')
            ->orderBy('products.id', 'DESC')
            ->get();
        return response()->json($product);
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
            'product_name'    => 'required',
            'product_code'    => 'required|unique:products',
            'category_id'     => 'required',
            'supplier_id'     => 'required',
            'product_quantity' => 'required',
            'buying_price'    => 'required',
        ]);

        if ($request->image) {
            $position    = strpos($request->image, ';');
            $sub         = substr($request->image, 0, $position);
            $ext         = explode('/', $sub)[1];
            $name        = time() . '.' . $ext;
            $img         = Image::make($request->image)->resize(240, 200);
            $upload_path = 'uploads/backend/product/';
            $image_url   = $upload_path . $name;
            $img->save($image_url);

            Product::insert([
                'product_name'     => $request->product_name,
                'product_code'     => $request->product_code,
                'category_id'      => $request->category_id,
                'supplier_id'      => $request->supplier_id,
                'product_quantity' => $request->product_quantity,
                'root'             => $request->root,
                'buying_price'     => $request->buying_price,
                'selling_price'    => $request->selling_price,
                'buying_date'      => $request->buying_date,
                'image'            => $image_url,
                'created_at'       => Carbon::now(),
            ]);
        } else {
            Product::insert([
                'product_name'     => $request->product_name,
                'product_code'     => $request->product_code,
                'category_id'      => $request->category_id,
                'supplier_id'      => $request->supplier_id,
                'product_quantity' => $request->product_quantity,
                'root'             => $request->root,
                'buying_price'     => $request->buying_price,
                'selling_price'    => $request->selling_price,
                'buying_date'      => $request->buying_date,
                'created_at'       => Carbon::now(),
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
        $product = Product::where('id', $id)->first();
        return response()->json($product);
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
        $data['category_id']      = $request->category_id;
        $data['supplier_id']      = $request->supplier_id;
        $data['product_name']     = $request->product_name;
        $data['product_code']     = $request->product_code;
        $data['buying_date']      = $request->buying_date;
        $data['product_quantity'] = $request->product_quantity;
        $data['root']             = $request->root;
        $data['buying_price']     = $request->buying_price;
        $data['selling_price']    = $request->selling_price;
        $data['image']            = $request->image;
        $image                    = $request->new_image;
        if ($image) {
            $position    = strpos($image, ';');
            $sub         = substr($image, 0, $position);
            $ext         = explode('/', $sub)[1];
            $name        = time() . '.' . $ext;
            $img         = Image::make($image)->resize(240, 200);
            $upload_path = 'uploads/backend/product/';
            $image_url   = $upload_path . $name;
            $success     = $img->save($image_url);
            if ($success) {
                $data['image'] = $image_url;
                $img           = DB::table('products')->where('id', $id)->first();
                $image_path    = $img->image;
                $done          = unlink($image_path);
                $user          = DB::table('products')->where('id', $id)->update($data);
            }
        } else {
            $data['image'] = $request->image;
            $user          = DB::table('products')->where('id', $id)->update($data);
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
        $product = Product::where('id', $id)->first();
        if ($product->image) {
            unlink($product->image);
        }
        Product::where('id', $id)->delete();
    }


    public function quantityUpdate(Request $request, $id)
    {
        $request->validate([
            'product_quantity' => 'required'
        ]);

        Product::where('id', $id)->update([
            'product_quantity' => $request->product_quantity,
        ]);
    }
}
