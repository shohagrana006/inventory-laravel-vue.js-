<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Extra;
use App\Model\Pos;
use App\Model\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function showCart()
    {
        return response()->json(Pos::latest()->get());
    }
    public function addCart($id)
    {
        $product = Product::where('id', $id)->first();

        $check = Pos::where('pro_id', $id)->first();

        if ($check) {
            Pos::where('pro_id', $id)->increment('pro_quantity');

            $product = Pos::where('pro_id', $id)->first();
            $subTotal = $product->pro_quantity * $product->pro_price;
            Pos::where('pro_id', $id)->update([
                'sub_total' => $subTotal,
            ]);
        } else {
            Pos::insert([
                'pro_id'      => $id,
                'pro_name'    => $product->product_name,
                'pro_quantity' => 1,
                'pro_price'   => $product->selling_price,
                'sub_total'   => $product->selling_price,
                'created_at'  => Carbon::now(),
            ]);
        }
        return response()->json($product);
    }

    public function increment($id)
    {
        Pos::where('id', $id)->increment('pro_quantity');

        $product = Pos::where('id', $id)->first();
        $subTotal = $product->pro_quantity * $product->pro_price;
        Pos::where('id', $id)->update([
            'sub_total' => $subTotal,
        ]);
    }

    public function decrement($id)
    {
        Pos::where('id', $id)->decrement('pro_quantity');

        $product = Pos::where('id', $id)->first();
        $subTotal = $product->pro_quantity * $product->pro_price;
        Pos::where('id', $id)->update([
            'sub_total' => $subTotal,
        ]);
    }

    public function deleteCart($id)
    {
        Pos::where('id', $id)->delete();
    }

    // vat start
    public function vat()
    {
        return response()->json(Extra::first());
    }
    // vat end


}
