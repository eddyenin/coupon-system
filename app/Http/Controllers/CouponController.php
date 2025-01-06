<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function check(Request $request){
        $couponCode = $request->input('code');

       // $coupon = Coupon::where()
    }
}
