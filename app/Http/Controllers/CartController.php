<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(){

        return view('cart');
    }

    public function show(Request $request){
        $productIds = $request->input('ids');
        $product = Product::find($productIds);

        return response()->json($product);
    }
}
