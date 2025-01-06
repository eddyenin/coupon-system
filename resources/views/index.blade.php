<x-layout>
    <section>
        <div class="container ">
            <div class="row">
                <h2 class="mt-2">Products</h2>
                    @foreach ($products as $product)
                    <div class="col-md-4 mt-2">
                        <div class="card p-3">
                            <div class="card-body">
                            <h5 class="card-title product-name">{{ $product->name }}</h5>
                            <p class="card-text product-price"><span>${{ $product->price }}</span></p>
                            </div>
                            <div class="d-flex justify-content-end productBtn">
                                <a href="javascript:void(0)" class="btn btn-sm btn-primary p-2 adBtn" onclick="addToCart({{ $product->id }})" id="addBtn">Add to cart</a>
                                <div class="quantity-controls" style="display: none">
                                    <button class="decrease btn btn-sm btn-danger">-</button>
                                    <span class="quantity">1</span>
                                    <button class="increase btn btn-sm btn-primary">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                     @endforeach
            </div>
        </div>
    </section>
</x-layout>
