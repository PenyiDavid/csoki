<?php

namespace App\Http\Controllers;
use Illuminate\Validation\ValidationException;

use App\Models\Chocolate;
use Illuminate\Http\Request;

class ChocolateController extends Controller
{
    public function index(){
        $chocolates = Chocolate::all();
        return response()->json($chocolates);
    }

    public function store(Request $request){
        try {
            $request->validate([
                'brand'=>'required|string',
                'chocolate_name'=>'required|string',
                'price'=>'required|numeric',
                'expiry_date'=>'required|date',
            ]);
 
        } catch (ValidationException $th) {
            //->header('Access-Control-Allow-Origin','*')
            return response()->json(['success'=>false,'message'=>$th->errors()],201,['Access-Control-Allow-Origin'=>'*'],JSON_UNESCAPED_UNICODE);
        }
        Chocolate::create([
            'brand'=>$request->brand,
            'chocolate_name'=>$request->chocolate_name,
            'price'=>$request->price,
            'expiry_date'=>$request->expiry_date,
        ]);
        return response()->json(['success'=>true,'message'=>'Rekord sikeresen hozzáadva!'],201,['Access-Control-Allow-Origin'=>'*'],JSON_UNESCAPED_UNICODE);
    }
}
