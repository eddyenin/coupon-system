$(document).ready(function(){
    addToCart;
    getProductId();
    productIncrease;
});

//Add product ids to Local storage and create an object of ids and quanity
function addToCart(productId){
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    let cartIndex = cart.findIndex(function(cartPi){
        return cartPi.id === productId;
    });

    if(cartIndex !== -1){
        cart[cartIndex].quantity += 1
    }else{
        cart.push({id:productId,quantity:1});
    }
    localStorage.setItem('cart',JSON.stringify(cart));
    console.log(localStorage.getItem('cart'))
}

//Get product ids from local storage and store in an array,use it to send with AJAX to get product details
function getProductId(){
    let cartDetails = JSON.parse(localStorage.getItem('cart')) || [];

    let productIds = [];
    if (cartDetails == []){
        console.log('no products')
    }else{
        cartDetails.forEach(function(productId){
            productIds.push(productId.id);
        })
    }

    displayCartDetails(productIds, cartDetails); //Get product details from Laravel with AJAX and display
    //console.log(productIds);
}

//Show product details in the cart page
function displayCartDetails(productIds,cartDetails){
    $.ajax({
        url:'/show',
        type:'GET',
        data:{
            ids:productIds,
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success:function(response){
            let productCard = $("#cart-row");
            let totalCard = $("#cart-row")
            let totalAmount = 0;
            response.forEach(function(product){
                let cartPrId = cartDetails.find(function(prId){
                    return prId.id === product.id
                })
                let quantity = cartPrId.quantity;
                let productTotal = Math.round(product.price) * quantity
                totalAmount += productTotal;

                let row = `
                <div class="d-flex justify-content-between">
                    <div id="pName">
                        <span>${product.name}</span>
                    </div>
                    <div>
                        <span id="pPrice">$${Math.round(product.price)}</span>
                    </div>
                    <div class="mt-2 mb-2 quantity-controls">
                         <span class="btn btn-sm btn-primary">-</span>
                         <span class="p-1 quantity-display" id="${product.id}-quantity">${quantity}</span>
                         <span class="btn btn-sm btn-primary" onclick="productIncrease(${product.id})">+</span>
                     </div>
                    <div id="ptotal">
                        <span id="${product.id}-total">${productTotal}</span>
                    </div>
                </div>
                `;
                productCard.prepend(row);
            })
            let wor = `
            <div class="d-flex justify-content-between">
                <div>
                    <p><strong>Total</strong></p>
                </div>
                <div>
                    <span class="fw-bold" id="subTotal">$${totalAmount}</span>
                </div>
            </div>

            `;
            totalCard.append(wor);

        }
    })
}

function getCoupon(){
    let couponCode = $("#couponCode").val();
    if (!couponCode){
        alert('Please enter a coupon code');
    }

    $.ajax({
        url:'/check',
        type:'GET',
        data:{
            code:couponCode,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(response){
            console.log(response)
        }

    })
}

function productIncrease(pId){

    quantityUpdate(pId,1)
    let quantityEl = $(`#${pId}-quantity`);
    let pTotalEl = $(`#${pId}-total`);

    let quantity = parseInt(quantityEl.text());
    let pTotal = parseInt(pTotalEl.text());
   let rt = quantityEl.text(quantity + 1);

}



function quantityUpdate(pId,quan){
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let cartIndex = cart.findIndex(function(cartPrI){
        return cartPrI.id === pId;
    })

    if(cartIndex !== -1){
        cart[cartIndex].quantity += quan;
        // console.log(quantity)
        localStorage.setItem('cart',JSON.stringify(cart));
    }
}
