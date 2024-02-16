@extends('User.masteruser')

@section('content')
<!-- Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{ url('user/dashboard') }}">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ul>
        </div>
    </div>
</div>
<!-- Shopping Cart Area -->
<div class="Shopping-cart-area pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if (count($cartItems) > 0)
                <form action="#">
                    <div class="table-content table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="li-product-remove">Remove</th>
                                    <th class="li-product-thumbnail">Images</th>
                                    <th class="cart-product-name">Product</th>
                                    <th class="li-product-price">Unit Price</th>
                                    <th class="li-product-quantity">Quantity</th>
                                    <th class="li-product-subtotal">Total</th>
                                    <th>Choose</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <td class="li-product-remove">
                                            <a href="{{ route('user.cartremove', ['productId' => $item['id'],'inputColor' => $item['color'] ,'inputSize' => $item['size']]) }}">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                        <td class="li-product-thumbnail">
                                            <a href="#">
                                                <img width="30%" src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['image'] }}">
                                            </a>
                                        </td>
                                        <td class="li-product-name">
                                            <a href="{{ url('user/productdetail/' . $item['id']) }}">{{ $item['name'] }}</a>
                                            <p>@if(!empty($item['color'])){{ $item['color'] }}@endif @if(!empty($item['size']))& {{ $item['size'] }}@endif</p>
                                            <p hidden class="ID" >{{$item['id']}}</p>
                                        </td>
                                        <td class="li-product-price">
                                            <span class="amount">Rs{{ number_format($item['price'], 0, '.', ',') }}</span>
                                        </td>
                                        <td class="quantity">

                                            <div class="cartquantity">
                                                <input class="cart-plus-minus-box" data-price="{{ $item['price'] }}" value="{{ $item['quantity'] }}" type="number" min="1">
                                            </div>
                                        </td>
                                        <td class="product-subtotal">
                                            <span class="amount">Rs{{ number_format($item['quantity'] * $item['price'], 0, '.', ',') }}</span>
                                        </td>
                                        <td>
                                            <input type="checkbox" data-price="{{ $item['price'] }}">
                                            <p class="productcolor" id="productcolor" hidden>{{$item['color']}}</p>
                                            <p class="productsize" id="productsize" hidden>{{$item['size']}}</p>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="no-product-message text-center">
                        <h3>No products in the cart.</h3>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-5 ml-auto">
                            <div class="cart-page-total">
                                <h2>Cart totals</h2>
                                <ul>
                                    <li>Subtotal <span>Rs: 0</span></li>
                                    <li>Total <span>Rs: 0</span></li>
                                </ul>
                                <a href="#" class="proceed-to-checkout">Proceed to checkout</a>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    $(document).ready(function() {

        $('.cart-plus-minus-box').on('change', function() {
            var quantity = $(this).val();
            var price = $(this).data('price');
            var subtotal = quantity * price;
            var formattedSubtotal = subtotal.toLocaleString();
            $(this).closest('.quantity').siblings('.product-subtotal').find('.amount').text('Rs' + formattedSubtotal);

            // Calculate cart total
            calculateCartTotal();
        });

        $('input[type="checkbox"]').on('change', function() {
            // Calculate cart total
            calculateCartTotal();
        });

        function calculateCartTotal() {
    var totalPrice = 0;
    var totalSubtotal = 0;

    $('input[type="checkbox"]:checked').each(function() {
        var quantity = parseFloat($(this).closest('tr').find('.cart-plus-minus-box').val());
        var price = parseFloat($(this).data('price'));
        var subtotal = quantity * price;
        totalPrice += subtotal;
        totalSubtotal += subtotal;
    });

    // Update the cart total and subtotal amounts
    $('.cart-page-total ul li:last-child span').text('Rs: ' + totalPrice.toFixed(0));
    $('.cart-page-total ul li:first-child span').text('Rs: ' + totalSubtotal.toFixed(0));
}

    });

    $(document).ready(function() {
  // ...

  $('a.proceed-to-checkout').on('click', function(e) {
  e.preventDefault();

  // Get the checked products
  var checkedProducts = [];
  $('input[type="checkbox"]:checked').each(function() {
    var productId = $(this).closest('tr').find('.li-product-name .ID').text();
    var productName = $(this).closest('tr').find('.li-product-name a').text();
    var productImage = $(this).closest('tr').find('.li-product-thumbnail img').attr('src');
    var quantity = parseFloat($(this).closest('tr').find('.cart-plus-minus-box').val());
    var price = $(this).closest('tr').find('.li-product-price .amount').text();
    var color = $(this).closest('tr').find('#productcolor').text();
    var size = $(this).closest('tr').find('#productsize').text();

    checkedProducts.push({
      productId: productId,
      productName: productName,
      productImage: productImage,
      quantity: quantity,
      price: price,
      color: color,
      size: size
    });
  });

 // Generate the URL with the checked products data
var url = "{{ url('user/proceedtocheckout') }}?";
checkedProducts.forEach(function(product, index) {
  url +=
    "productId" + index + "=" + encodeURIComponent(product.productId) +
    "&productName" + index + "=" + encodeURIComponent(product.productName) +
    "&productImage" + index + "=" + encodeURIComponent(product.productImage) +
    "&quantity" + index + "=" + product.quantity +
    "&price" + index + "=" + encodeURIComponent(product.price) +
    "&color" + index + "=" + encodeURIComponent(product.color) +
    "&size" + index + "=" + encodeURIComponent(product.size);

  if (index < checkedProducts.length - 1) {
    url += "&";
  }
});

// Redirect to the checkout page
window.location.href = decodeURIComponent(url);

});


  // ...
});



</script>

@endpush
