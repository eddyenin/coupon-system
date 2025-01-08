<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use App\Models\Product;
use App\Traits\HasDiscount;
use Exception;

class CouponController extends Controller
{
    use HasDiscount;

    public function getDiscount(CouponRequest $request){
            $couponCode = $request->couponCode;
            $products = $request->products;

        try{
            $coupon = Coupon::with('discount')->where('coupon_code',$couponCode)->first();

            if (!$coupon) {
                return response()->json(['error' => 'Coupon not found'], 404);
            }

            $currentDate = now();

            if ($coupon->max <= 0 || $currentDate->isAfter($coupon->expires_at)) {
                return response()->json(['error' => 'Coupon is not valid or has expired'], 400);
            }

            $totalAmount = 0;
            foreach($products as $productData){
                $product = Product::find($productData['id']);
                $productTotal = $product->price * $productData['quantity'];
                $totalAmount += $productTotal;
            }

            $itemCount = count($products);
            $discountAmount = $this->applyDiscount($coupon->discount,$totalAmount,$itemCount);
            return response()->json(['discountAmount'=>$discountAmount]);

        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

}
