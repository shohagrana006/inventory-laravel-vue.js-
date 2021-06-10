<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Expense;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Pos;
use App\Model\Product;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function getProduct($id)
    {
        $product = Product::where('category_id', $id)->get();
        return response()->json($product);
    }

    public function orderDone(Request $request)
    {
        $validateData = $request->validate([
            'customer_id' => 'required',
            'payby'       => 'required',
        ]);

        $order_id = Order::insertGetId([
            'customer_id' => $request->customer_id,
            'qty'         => $request->qty,
            'sub_total'   => $request->subtotal,
            'vat'         => $request->vat,
            'total'       => $request->total,
            'pay'         => $request->pay,
            'due'         => $request->due,
            'payby'       => $request->payby,
            'order_date'  => date('d/m/Y'),
            'order_month' => date('F'),
            'order_year'  => date('Y'),
        ]);

        $contents = DB::table('pos')->get();

        foreach ($contents as $content) {
            OrderDetail::insert([
                'order_id'     => $order_id,
                'product_id'   => $content->pro_id,
                'pro_quantity' => $content->pro_quantity,
                'pro_price'    => $content->pro_price,
                'sub_total'    => $content->sub_total,
            ]);

            Product::where('id', $content->pro_id)->update([
                'product_quantity' => DB::raw('product_quantity -' . $content->pro_quantity)
            ]);
        }
        DB::table('pos')->delete();
        return response('Doneeeeeeeeeeeee');
    }

    public function searchOrder(Request $request)
    {
        $orderdate = $request->date;
        $newDate = new DateTime($orderdate);
        $done = $newDate->format('d/m/Y');

        $order = DB::table('orders')
            ->join('customers', 'orders.customer_id', 'customers.id')
            ->select('customers.name', 'orders.*')
            ->where('orders.order_date', $done)
            ->get();
        return response()->json($order);
    }

    public function todaySell()
    {
        $date = date('d/m/Y');
        $sell = Order::where('order_date', $date)->sum('total');
        return response()->json($sell);
    }

    public function todayIncome()
    {
        $date = date('d/m/Y');
        $income = Order::where('order_date', $date)->sum('pay');
        return response()->json($income);
    }

    public function todayDue()
    {
        $date = date('d/m/Y');
        $income = Order::where('order_date', $date)->sum('due');
        return response()->json($income);
    }

    public function todayExpense()
    {
        $date = date('Y/m/d');
        $expense = Expense::where('date', $date)->sum('ammount');
        return response()->json($expense);
    }

    public function stockOut()
    {
        $product = Product::where('product_quantity', '<', '1')->get();
        return response()->json($product);
    }
}
