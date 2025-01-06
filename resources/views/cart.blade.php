<x-layout>
    <section>
        <div class="container">
            <div class="row" >
                <h2 class="mt-2">Cart</h2>
                <div class="col-md-12 mt-2 " >
                    <div class="card p-3">
                        <h5 class="card-title product-name">Cart summary</h5>
                        <hr>
                        <div class="card-body" id="cart-row">

                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <div>
                                <input type="text" placeholder="Enter Coupon Code" class="p-2" id="couponCode"> <button class="btn btn-sm btn-primary" onclick="getCoupon()" id="couponBtn">Apply code</button>
                            </div>
                            <div>
                                <a href="javascript:void(0)" class="btn btn-sm btn-primary ">Confirm Order</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</x-layout>
