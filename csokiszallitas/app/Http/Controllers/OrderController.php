<?php

namespace App\Http\Controllers;

use App\Models\Chocolate;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::all();
        return response()->json($orders);
    }

    public function store(Request $request){
        try {
            $request->validate([
                'email'=>'required|string',
                'address'=>'required|string',
                'chocolate_id'=>'required|numeric|exists:chocolates,id',
                //'chocolate_brand'=>'required|string',
                //'chocolate_name'=>'required|string',
                'count'=>'required|numeric',
            ]);
        } catch (ValidationException $th) {
            return response()->json(['success'=>false,'message'=>$th->errors()],201,['Access-Control-Allow-Origin'=>'*'],JSON_UNESCAPED_UNICODE);
        }
        
        /*$chocolate = Chocolate::where('brand',$request->chocolate_brand)
                                ->where('chocolate_name',$request->chocolate_name)
                                ->first(); //query builder
                                */
        $chocolate = Chocolate::find($request->chocolate_id);

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

    public function destroy($id){
        $order = Order::find($id);
        if($order){
            $order->delete();
            return response()->json(['success'=>true,'message'=>'Rekord sikeresen törölve!'],200,['Access-Control-Allow-Origin'=>'*'],JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['success'=>false,'message'=>'Rekord nem található!'],404,['Access-Control-Allow-Origin'=>'*'],JSON_UNESCAPED_UNICODE);
    }
}
