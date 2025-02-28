<?php

namespace App\Http\Controllers;

use App\Models\Chocolate;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::all();
        return response()->json($orders);
    }

    public function store(Request $request){
        $request->validate([
            'email'=>'required|string',
            'address'=>'required|string',
            'chocolate_brand'=>'required|string',
            'chocolate_name'=>'required|string',
            'count'=>'required|numeric',
        ]);
        $chocolate = Chocolate::where('brand',$request->chocolate_brand)
                                ->where('chocolate_name',$request->chocolate_name)
                                ->first(); //query builder

        $all_price = $chocolate->price * $request->count;
        Order::create([
            'email'=>$request->email,
            'address'=>$request->address,
            'chocolate_id'=>$chocolate->id,
            'count'=>$request->count,
            'all_price'=>$all_price,
        ]);
        return response()->json(['success'=>true,'message'=>'Rekord sikeresen hozzáadva!'],201,['Access-Control-Allow-Origin'=>'*'],JSON_UNESCAPED_UNICODE);
    }
}
