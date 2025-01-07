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

    cartDetails.forEach(function(productId){
        productIds.push(productId.id);
    })

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
            const productCard = $("#cart-row");
            let totalAmount = 0;
            response.forEach(function(product){
                let cartPrId = cartDetails.find(function(prId){
                    return prId.id === product.id
                })
                let quantity = cartPrId.quantity;
                let productTotal = product.price * quantity
                totalAmount += productTotal;

                let row = `
                <div class="d-flex justify-content-between">
                    <div id="pName" class="col-3">
                        <span>${product.name}</span>
                    </div>
                    <div class="d-flex justify-content-evenly display">
                        <div class="mx-4">
                             <span id="${product.id}-price">${product.price}</span>

                        </div>
                        <div class="mt-2 mb-2 quantity-controls ">
                            <span class="btn btn-sm btn-primary" onclick="productDecrease(${product.id})">-</span>
                            <span class="p-1 quantity-display" id="${product.id}-quantity">${quantity}</span>
                            <span class="btn btn-sm btn-primary" onclick="productIncrease(${product.id})">+</span>
                        </div>
                    </div>

                    <div id="ptotal">
                        <span id="${product.id}-total">${productTotal.toFixed(2)}</span>
                    </div>
                </div>
                `;
                productCard.prepend(row);
            })

            localStorage.setItem('total',totalAmount);
            $("#totalAmount").text(totalAmount.toFixed(2))
        }
    })
}

function validateCouponCode(couponCode) {
    if (!couponCode || couponCode.trim() === '') {
        showAlert('Please enter a valid coupon code.');
        return false;
    }
    return true;
}

function showAlert(message) {
    alert(message);
}



function getDiscount(){
    let products = JSON.parse(localStorage.getItem('cart')) || [];
    let couponCode = $("#couponCode").val();
    let finalAmountEl = $("#totalAmount");

    if (!validateCouponCode(couponCode)){
        alert('Please enter a coupon code');
    }

    $.ajax({
        url:'/check',
        type:'POST',
        data:{
            couponCode:couponCode,
            products:products,
        },
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(response){
            if(response.discountAmount){
                const finalAmount = response.discountAmount.toFixed(2);
                $("#totalAmount").text(finalAmount)

                localStorage.setItem('total',finalAmount);
            }
        },
        error: function(xhr) {
            console.log('Error:', xhr.responseJSON);
        }

    })
}

//Increase the quantity and update product total and display
function productIncrease(pId){
    quantityUpdate(pId,1);

    const quantityEl = $(`#${pId}-quantity`);
    const productPrice = parseFloat($(`#${pId}-price`).text());
    const productTotalEl = $(`#${pId}-total`);

    let quantity = parseInt(quantityEl.text()) + 1;
    quantityEl.text(quantity);

    const productTotal = (quantity * productPrice).toFixed(2);
    productTotalEl.text(productTotal);

    updateTotalAmount(pId);

}

//Decrease the quantity and update product total and display
function productDecrease(pId){
    const quantityEl = $(`#${pId}-quantity`);
    const productTotalEl = $(`#${pId}-total`);
    let quantity = parseInt(quantityEl.text());

    if(quantity > 1){
        quantityUpdate(pId,-1);
        quantity -=1;
        quantityEl.text(quantity);

        const productPrice = parseFloat($(`#${pId}-price`).text());
        const producTotal =  (quantity  * productPrice).toFixed(2)
        productTotalEl.text(producTotal);

        updateTotalAmount(pId);
    }
}


// Update the quanity of the product in the local storage
function quantityUpdate(pId,quan){
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let cartIndex = cart.findIndex(function(cartPrI){
        return cartPrI.id === pId;
    })

    if(cartIndex !== -1){
        cart[cartIndex].quantity += quan;
        localStorage.setItem('cart',JSON.stringify(cart));
    }
}

function updateTotalAmount(pId){
    let totalAmount = 0;

    $(".display").each(function(){
        const quantity = parseInt($(`#${pId}-quantity`).text());
        const productPrice = parseFloat($(`#${pId}-price`).text())
        const productTotal = productPrice * quantity
        totalAmount += productTotal;

    })
    console.log(totalAmount);

    $("#totalAmount").text(totalAmount.toFixed(2))
    localStorage.setItem('total',totalAmount);
}
