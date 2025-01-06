<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use App\Models\Discounts;
use App\Models\Product;
use App\Traits\HasDiscount;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use function Pest\Laravel\json;

class CouponController extends Controller
{
    use HasDiscount;

    public function checkCoupon(CouponRequest $request){
            $couponCode = $request->couponCode;
            $products = $request->products;

        try{
            $coupon = Coupon::with('discount')->where('coupon_code',$couponCode)->first();

            $currentDate = now();

            if($coupon->max > 0 && $currentDate->isAfter($coupon->expires_at)){
                $itemCount = count($products);
                $totalAmount = 0;
                foreach($products as $productData){
                    $product = Product::find($productData['id']);
                    $productTotal = $product->price * $productData['quantity'];
                    $totalAmount += $productTotal;
                }
                dd($totalAmount);
                $discountValue = $this->applyDiscount($coupon->discount,$totalAmount,$itemCount);
                return response()->json(['discountValue'=>$discountValue]);
            }else{
                return response()->json(['error' => 'Coupon is not valid or is expired']);
            }
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }







    // public function create(CreateItemRequest $request) {
    //     $attachments = [];

    //     try {
    //         $user = $request->user();
    //         $businessId = $user->role_id == 1
    //             ? $user->businesses()->first()->id
    //             : $user->locations()->first()->business->id;

    //         DB::beginTransaction();

    //         // Upload item attachments
    //         foreach ($request->attachments as $attachment) {
    //             // Generate a unique file name
    //             $fileName = uniqid('item_', true) . '.' . $attachment['type'];
    //             // Upload file using Laravel's default storage
    //             Storage::disk('public')->putFileAs('items', $attachment['content'], $fileName);
    //             array_push($attachments, 'items/' . $fileName);
    //         }

    //         // Create the item
    //         $item = new Item();
    //         $item->name = $request->name;
    //         $item->category_id = $request->category;
    //         $item->price = $request->price;
    //         $item->prep_time = $request->prep_time;
    //         $item->all_locations = $request->all_locations;
    //         $item->business_id = $businessId;
    //         $item->attachments = json_encode($attachments);

    //         if ($request->has('description')) {
    //             $item->description = $request->description;
    //         }

    //         if ($request->has('unit_terminology')) {
    //             $item->unit_terminology = $request->unit_terminology;
    //         }

    //         $item->save();

    //         // Attach modifiers to item
    //         if ($request->has('modifiers')) {
    //             foreach ($request->modifiers as $modifier) {
    //                 $item->modifiers()->attach($modifier['id'], ['hide_from_receipts' => $modifier['hide'], 'req_modifiers' => $modifier['required'] ?? null, 'max_modifiers' => $modifier['max'] ?? null, 'created_at' => now(), 'updated_at' => now()]);
    //                 $item->preselectedModifiers()->syncWithoutDetaching($modifier['preselected']);
    //             }
    //         }

    //         // Attach locations to item
    //         if ($request->all_locations) {
    //             foreach (Location::where('business_id', $businessId)->get() as $location) {
    //                 $item->locations()->attach($location->id, ['created_at' => now(), 'updated_at' => now()]);
    //             }
    //         } else {
    //             $item->locations()->sync($request->locations);
    //         }

    //         DB::commit();

    //         return $this->with(new ItemResource($item))->success('', 201);
    //     } catch (\Throwable $th) {
    //         Log::error($th);

    //         // Rollback image upload
    //         foreach ($attachments as $attachment) {
    //             Storage::disk('public')->delete($attachment);
    //         }

    //         DB::rollBack();
    //         return $this->failure();
    //     }
    // }
}

}
