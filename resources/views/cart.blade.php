<x-layout>
    <section>
        <div class="container ">
            <div class="row" >
                <h2 class="mt-2">Cart</h2>
                <div class="col-md-12 mt-2 " >
                    <div class="card p-3">
                        <h5 class="card-title product-name">Cart summary</h5>
                        <hr>
                        <div class="card-body" id="cart-row">
                            <div class="d-flex justify-content-between ">
                                <div id="pname">
                                    <p>Product name</p>
                                </div>
                                <div id="">
                                    <span>$500</span>
                                </div>
                                <div class="mt-2 mb-2">
                                    <span class="btn btn-sm btn-primary">-</span><span class="p-1">3</span><span class="btn btn-sm btn-primary">+</span>
                                    </div>
                                <div id="ptotal">
                                    <span>$1000</span> <br>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between ">
                                <div id="pname">
                                    <p>Product name</p>

                                </div>
                                <div id="">
                                    <span>$500</span>

                                </div>
                                <div class="mt-2 mb-2">
                                    <span class="btn btn-sm btn-primary">-</span><span class="p-1">3</span><span class="btn btn-sm btn-primary">+</span>
                                    </div>
                                <div id="ptotal">
                                    <span>$1000</span> <br>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p><strong>Total</strong></p>

                                </div>
                                <div>
                                    <span class="fw-bold" id="t">$23000</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <div>
                                <input type="text" placeholder="Enter Coupon Code" class="p-2"> <button class="btn btn-sm btn-primary">Apply code</button>
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
