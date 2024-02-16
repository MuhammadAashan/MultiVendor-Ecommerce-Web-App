@extends('User.masteruser')
@section('content')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ url('user/dashboard') }}">Home</a></li>
                    <li class="active">Wishlist</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Li's Breadcrumb Area End Here -->
    <!--Wishlist Area Strat-->
    <div class="wishlist-area pt-60 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if ($wishlist->isEmpty())
                        <h3 class="text-center">Your wishlist is empty.</h3>
                    @else
                    <form id="wishlist-form">
                        <div class="table-content table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="li-product-remove">remove</th>
                                        <th class="li-product-thumbnail">images</th>
                                        <th class="cart-product-name">Product</th>
                                        <th class="li-product-price">Unit Price</th>
                                        <th class="li-product-stock-status">Stock Status</th>
                                        <th>Quantity</th>
                                        <th class="li-product-add-cart">add to cart</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wishlist as $cd)
                                        <tr>
                                            <td class="li-product-remove">
                                                <button class="btn btn-light wishlistremove"
                                                    data-id="{{ $cd->ID }}" data-color="{{$cd->Color}}" data-size="{{$cd->Size}}"><i class="fa fa-times"></i></button>
                                            </td>
                                            <td class="li-product-thumbnail">
                                                <a href="{{ url('user/productdetail/' . $cd->ID . '') }}">
                                                    <img width="20%" src="{{ asset('storage/' . $cd->CoverImage) }}"
                                                        alt="{{ $cd->CoverImage }}">
                                                </a>
                                            </td>
                                            <td class="li-product-name">
                                                <a
                                                    href="{{ url('user/productdetail/' . $cd->ID . '') }}">{{ $cd->Name }}
                                                </a>
                                                <p>
                                                    @if(!empty($cd->Color))
                                                    Color:{{$cd->Color}}
                                                    @endif
                                                    @if(!empty($cd->Size))
                                                    &
                                                    Size:{{$cd->Size}}
                                                    @endif
                                                </p>

                                                            <input type="hidden" name="color" class="bg-transparent border-white" value="{{$cd->Color}}">
                                                            <input type="hidden" name="size" class="bg-transparent border-white" value="{{$cd->Size}}" >



                                            </td>



                                                <!--if(count($productvariation) > 0)
                                                    <select name="color" class="form-control color-select">
                                                        <option value="">--Select Color--</option>
                                                        php
                                                            $selectedColors = [];
                                                        endphp
                                                        foreach ($productvariation as $variation)
                                                            if ($variation->Product_Id == $cd->Product_Id && !in_array($variation->Color, $selectedColors))
                                                                <option value="{ $variation->colorname }}">{ $variation->colorname }}</option>
                                                                php
                                                                    $selectedColors[] = $variation->Color;
                                                                endphp
                                                            endif
                                                        endforeach
                                                    </select>
                                                else
                                                    <p>No color options available</p>
                                                endif-->



                                                <!--
                                                if(count($productvariation) > 0 && count($selectedColors) > 0)
                                                    <select name="size" class="form-control size-select">
                                                        <option value="">--Select Size--</option>
                                                        foreach ($productvariation as $variation)
                                                            if ($variation->Product_Id == $cd->Product_Id && in_array($variation->Color, $selectedColors))
                                                                php
                                                                    $selectedColors = array_diff($selectedColors, [$variation->Color]);
                                                                endphp
                                                                <optgroup label="{ $variation->colorname }}" data-color="{ $variation->Color }}">
                                                                    foreach ($productvariation as $sizeVariation)
                                                                        if ($sizeVariation->Product_Id == $cd->Product_Id && $sizeVariation->Color == $variation->Color)
                                                                            <option value="{ $sizeVariation->sizename }}">{ $sizeVariation->sizename }}</option>
                                                                        endif
                                                                    endforeach
                                                                </optgroup>
                                                            endif
                                                        endforeach
                                                    </select>
                                                elseif(count($productvariation) > 0 && count($selectedColors) == 0)
                                                    <p>No size options available</p>
                                                else
                                                    <p>No variations available</p>
                                                endif-->


                                            <td class="li-product-price"><span
                                                    class="amount">Rs.{{ $cd->Price }}</span></td>
                                            @if ($cd->stock > 10)
                                                <td class="li-product-stock-status"><span class="in-stock">in
                                                        stock</span>
                                                </td>
                                            @else
                                                <td class="li-product-stock-status"><span class="text-danger">Low
                                                        stock</span>
                                                </td>
                                            @endif
                                            <td>
                                                <div class="quantity">
                                                    <div class="cart-plus-minus">
                                                        <input class="cart-plus-minus-box" type="text" value="1"
                                                            name="quantity">
                                                        <div class="dec qtybutton"><i class="fa fa-angle-down"></i>
                                                        </div>
                                                        <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="add-to-cart btn btn-primary" type="button"
                                                    data-id="{{ $cd->ID }}">Add to cart</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('.add-to-cart').click(function() {
            var button = $(this);
            var productId = button.data('id');
            var form = button.closest('tr');
            var color = form.find('input[name="color"]').val();
            var size = form.find('input[name="size"]').val();
            var quantity = form.find('input[name="quantity"]').val();

            // AJAX request to add the product to the cart
            $.ajax({
                url: '{{ url('user/addtocart') }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    colorof: color,
                    sizeof: size,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Handle the response
                    if (response.success) {
                        // Show a success message
                        alert('Product added to cart successfully!');

                        // Update the cart count in the header
                        $('#cart-count').text(response.cartCount);
                    } else {
                        // Show an error message
                        alert('Failed to add product to cart.');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.log(error);
                }
            });
        });

        $('.wishlistremove').click(function() {
            // Handle remove from wishlist
        });
    });
    </script>

@endpush
