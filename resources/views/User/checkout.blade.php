@extends('User.masteruser')
@section('content')

<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{ url('user/dashboard') }}">Home</a></li>
                <li class="active">Checkout</li>
            </ul>
        </div>
    </div>
</div>
<div class="checkout-area pt-60 pb-30">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="col-8 offset-2">
                    <h4>Please Choose your Delivery Address</h4>
                    <div class="checkout-form-list">
                      <label for="address_option">Address Option</label>
                      <select name="address_option" id="address_option" >
                        <option value="0" data-address="{{auth()->user()->address}}" data-mobileno="{{auth()->user()->mobileno}}" selected>Default Address</option>
                        <option value="1">Send on another Address</option>
                      </select>
                    </div>
                    <div id="custom_address_section">
                      <div class="checkout-form-list">
                        <label for="custom_address">Address <span class="required">*</span></label>
                        <input id="custom_address" class="customeraddress" name="customeraddress"  placeholder="Street address" type="text" disabled>
                        <label for="custom_mobileno">MobileNO <span class="required">*</span></label>
                        <input id="custom_mobileno" class="customeraddress" name="customermobileno"  placeholder="Mobile Number" type="text" disabled>

                      </div>
                    </div>
                  </div>

                <div class="col-8 offset-2">
                <div class="your-order">
                    <h3>Your order</h3>
                    <div class="your-order-table table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="cart-product-name">Product</th>
                                    <th class="cart-product-total">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="cart_item">
                                  <td class="cart-product-name"> Product<strong class="product-quantity"> × 1</strong></td>
                                  <td class="cart-product-total"><span class="amount">Rs: 165</span></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="cart-subtotal">
                                    <th>Cart Subtotal</th>
                                    <td><span class="amount">Rs: 0</span></td>
                                </tr>
                                <tr class="order-total">
                                    <th>Order Total</th>
                                    <td><strong><span class="amount">Rs: 0</span></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="payment-method">
                        <div class="payment-accordion">
                            <h5>Cash On Delivery</h5>
                            <div class="order-button-payment text-center pt-5">
                                <button class="place-order btn btn-success" > Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
$(document).ready(function() {
  // Get the URL parameter
  var checkedProducts = [];
  var urlParam = decodeURIComponent(window.location.search.substring(1));

  // Parse the URL parameter to retrieve the checked products data
  var params = urlParam.split('&');
  var checkedProducts = [];

  params.forEach(function(param) {
    var paramData = param.split('=');
    var key = paramData[0];
    var value = decodeURIComponent(paramData[1]);

    if (key.startsWith('productId')) {
      var index = key.match(/\d+/)[0];

      if (!checkedProducts[index]) {
        checkedProducts[index] = {};
      }

      checkedProducts[index].productId = value;
    } else if (key.startsWith('productName')) {
      var index = key.match(/\d+/)[0];

      if (!checkedProducts[index]) {
        checkedProducts[index] = {};
      }

      checkedProducts[index].productName = value;
    } else if (key.startsWith('productImage')) {
      var index = key.match(/\d+/)[0];

      if (!checkedProducts[index]) {
        checkedProducts[index] = {};
      }

      checkedProducts[index].productImage = value;
    } else if (key.startsWith('quantity')) {
      var index = key.match(/\d+/)[0];

      if (!checkedProducts[index]) {
        checkedProducts[index] = {};
      }

      checkedProducts[index].quantity = parseFloat(value);
    } else if (key.startsWith('price')) {
      var index = key.match(/\d+/)[0];

      if (!checkedProducts[index]) {
        checkedProducts[index] = {};
      }

      checkedProducts[index].price = value;
    } else if (key.startsWith('color')) {
      var index = key.match(/\d+/)[0];

      if (!checkedProducts[index]) {
        checkedProducts[index] = {};
      }

      checkedProducts[index].color = value;
    } else if (key.startsWith('size')) {
      var index = key.match(/\d+/)[0];

      if (!checkedProducts[index]) {
        checkedProducts[index] = {};
      }

      checkedProducts[index].size = value;
    }
  });

  // Display the checked products data on the page
  var tableBody = $('table.table tbody');
  var cartSubtotal = 0;

  tableBody.empty(); // Clear the table body

  checkedProducts.forEach(function(product) {
    var row = $('<tr>').addClass('cart_item');
    var productName = $('<td>').addClass('cart-product-name').text(product.productName);
    var color = $('<span>').addClass('product-color').text(' Color: ' + product.color);
    var size = $('<span>').addClass('product-size').text(' Size: ' + product.size);
    var quantity = $('<strong>').addClass('product-quantity').text(' × ' + product.quantity);
    productName.append(color, size, quantity);
    var productTotal = $('<td>').addClass('cart-product-total').append($('<span>').addClass('amount').text('Rs:'+ parseFloat(product.price.replace(/[^\d.]/g, ''))*product.quantity));
    row.append(productName, productTotal);
    tableBody.append(row);

    // Calculate the subtotal
    var price = parseFloat(product.price.replace(/[^\d.]/g, ''));
    cartSubtotal += price * product.quantity;
  });

  // Display cart subtotal
  var cartSubtotalRow = $('tr.cart-subtotal');
  cartSubtotalRow.find('.amount').text('Rs: ' + cartSubtotal.toFixed(0));

  // Calculate order total (same as cart subtotal in this case)
  var orderTotalRow = $('tr.order-total');
  orderTotalRow.find('.amount').text('Rs: ' + cartSubtotal.toFixed(0));

  // Event handler for Place Order button
  $('button.place-order').on('click', function() {
    // Get the address from the input field
    var address = $('.customeraddress').val();
    var mobileno=$('#custom_mobileno').val();

    // Save order data and order detail data

    var orderDetailData = checkedProducts.map(function(product) {
      return {
        productId: product.productId,
        totalbill:cartSubtotal,
        quantity: product.quantity,
        price: parseFloat(product.price.replace(/[^\d.]/g, '')),
        color: product.color,
        size: product.size,
        address: address,
        mobileno: mobileno
      };
    });

    // Include CSRF token in the AJAX request headers
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    console.log('orderDetailData:', orderDetailData);
    // Perform the necessary AJAX request to save the data
    $.ajax({
      url: '{{route("user.placed")}}',
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken
      },
      data: {
        orderDetails: orderDetailData
      },
      success: function(response) {
        // Handle the success response

        console.log(response.message);
        window.location.href = "{{ url('user/dashboard') }}";
        alert('Your Order Placed Successfully');
        // Optionally, redirect to a thank-you page or perform other actions
      },
      error: function(error) {
        // Handle the error response
        console.error('Failed to place the order:', error);
      }
    });
  });
});





$(document).ready(function() {
  // Set the initial value of custom_address input field
  var defaultAddress = $('#address_option option:selected').data('address');
  var mobileno = $('#address_option option:selected').data('mobileno');
  $('#custom_address').val(defaultAddress);
  $('#custom_mobileno').val(mobileno);

  $('#address_option').change(function() {
    var selectedOption = $(this).val();
    if (selectedOption === '1') {
      $('#custom_address').prop('disabled', false);
      $('#custom_address').val('');
      $('#custom_mobileno').prop('disabled', false);
      $('#custom_mobileno').val('');
    } else {
      $('#custom_address').prop('disabled', true);
      var address = $(this).find(':selected').data('address');
      var mobileno = $('#address_option option:selected').data('mobileno');
      $('#custom_address').val(address);
      $('#custom_mobileno').val(mobileno);
    }
  });
});



</script>

@endpush
