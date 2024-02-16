@extends('User.masteruser')
@section('content')
<style>
    .button {
  float: left;
  margin: 0 2px 0 0;
  width: 50px;
  height: 45px;
  position: relative;
  color: black;
}

.button label,
.button input {
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
justify-content: center;
  text-align: center;
}

.button input[type="radio"] {
  opacity: 0.011;
  z-index: 100;
}

.button input[type="radio"]:checked + label {
  background: green;
  border-radius: 7px;
  color: white;
}

.button label {
  cursor: pointer;
  z-index: 90;
  line-height: 20px;
}

</style>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ url('user/dashboard') }}">Home</a></li>
                    <li class="active">Product Detail</li>
                </ul>
            </div>
        </div>
    </div>
    @foreach ($products as $product)
        <!-- Li's Breadcrumb Area End Here -->
        <!-- content-wraper start -->
        <div class="content-wraper">
            <div class="container">
@php
    $selectedSize = null;
    $selectedColor=null;
@endphp
                <div class="row single-product-area">

                    <div class="col-lg-5 col-md-6">
                        <!-- Product Details Left -->
                        <div class="product-details-left">
                            <div class="product-details-images slider-navigation-1">
                                <div class="lg-image">
                                    <a class="popup-img venobox vbox-item"
                                        href="{{ asset('storage/' . $product->CoverImage) }}" data-gall="myGallery">
                                        <img width="30%" src="{{ asset('storage/' . $product->CoverImage) }}"
                                            alt="{{ $product->CoverImage }}"></a>
                                </div>
                                @foreach ($productimages as $cd)
                                    <div class="lg-image">
                                        <a class="popup-img venobox vbox-item" href="{{ asset('storage/' . $cd->Image) }}"
                                            data-gall="myGallery">

                                            <img width="30%" src="{{ asset('storage/' . $cd->Image) }}"
                                                alt="{{ $cd->Image }}"></a>

                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                            <div class="product-details-thumbs slider-thumbs-1">
                                <div class="sm-image"> <img width="20%"
                                        src="{{ asset('storage/' . $product->CoverImage) }}"
                                        alt="{{ $product->CoverImage }}">
                                </div>
                                @foreach ($productimages as $cd)
                                    <div class="sm-image">

                                        <img width="20%" src="{{ asset('storage/' . $cd->Image) }}"
                                            alt="{{ $cd->Image }}">

                                    </div>
                                @endforeach

                            </div>

                        </div>
                        <!--// Product Details Left -->
                    </div>

                    <div class="col-lg-7 col-md-6">
                        <div class="product-details-view-content pt-60">
                            <div class="product-info">



                                <h2>{{ $product->Name }}</h2>
                                <span class="product-details-ref">Product No:{{ $product->ID }}</span>
                                <div class="rating-box pt-20">

                                    <ul class="rating rating-with-review-item">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $avgrating)
                                                <li><i class="fa fa-star"></i></li>
                                            @else
                                                <li><i class="fa fa-star-o"></i></li>
                                            @endif
                                        @endfor
                                        <li>({{ $avgrating }})</li>
                                    </ul>

                                </div>
                                <div class="price-box pt-20">
                                    <span class="new-price new-price-2">Rs. {{ $product->Price }}</span>
                                </div>


                                <div class="product-variants">
                                    @if ($productvariation->isNotEmpty())
                                        <div class="row">
                                            @if ($productvariation->whereNotNull('colorname')->count() > 0)
                                                <label for="color">Colors</label>
                                                @php
                                                    $selectedColor = null;
                                                @endphp
                                                @foreach ($productvariation as $variation)
                                                    <div class="col-2">

                                                        @if ($loop->first || $variation->colorname != $productvariation[$loop->index - 1]->colorname)
                                                        <div class="button">
                                                                <input type="radio" name="color"
                                                                    value="{{ $variation->Color }}" class="color-radio"
                                                                    id="color-{{ $variation->Color }}"
                                                                    {{ $loop->first ? 'checked' : '' }}>
                                                                    <label for="color"style="width: 50px;" class="p-2">{{ $variation->colorname }}</label>
                                                        </div>
                                                            @php
                                                                if ($loop->first) {
                                                                    $selectedColor = $variation->Color;
                                                                }
                                                            @endphp
                                                        @endif
                                                    </div>

                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="row">
                                            @if ($productvariation->whereNotNull('sizename')->count() > 0)
                                                <label for="size">Sizes</label>
                                                <div class="col-12">
                                                    @foreach ($productvariation as $variation)
                                                        @if ($loop->first || $variation->colorname != $productvariation[$loop->index - 1]->colorname)
                                                            <div class="size-options" id="size-options-{{ $variation->Color }}"
                                                                style="display: none;">
                                                                @foreach ($productvariation as $sizeVariation)
                                                                    @if ($sizeVariation->Color == $variation->Color)
                                                                    <div class="button">
                                                                            <input type="radio" name="size"
                                                                                value="{{ $sizeVariation->Size }}"
                                                                                class="size-radio  d-block "
                                                                                id="size-{{ $sizeVariation->Size }}"  {{ $loop->first ? 'checked' : '' }}>
                                                                        <label class="p-2" style="width: 50px;" for="size-radio"> {{ $sizeVariation->sizename }}</label>
                                                                    </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    @php
                                                        $selectedSize = null;
                                                        foreach ($productvariation as $sizeVariation) {
                                                            if ($sizeVariation->Color == $selectedColor) {
                                                                $selectedSize = $sizeVariation->Size;
                                                                break;
                                                            }
                                                        }
                                                    @endphp
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="single-add-to-cart">
                                    <form action="{{ url('user/addtocart') }}" method="POST" class="cart-quantity">
                                        @csrf
                                        <div class="quantity">
                                            <label>Quantity</label>
                                            <input type="hidden" name="product_id" value="{{ $product->ID }}">
                                            <input type="hidden" name="sizeof" value"">
                                            <input type="hidden" name="colorof" value="">
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box" type="text" value="1"
                                                    name="quantity">
                                                <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                                <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                            </div>
                                        </div>
                                        <label id="avlstock">Available Stock
                                        </label>
                                        @if($productvariation->pluck('Quantity')->max() > 0)
                                        <button class="add-to-cart" id="add-to-cart" type="submit">Add to cart</button>
                                        @else
                                        <button class="add-to-cart " id="add-to-cart" type="submit" disabled>Out of stock</button>
                                        @endif
                                    </form>
                                </div>
                                <div class="product-additional-info pt-25">
                                    @if(count($productvariation)>0)
                                    <button class="wishlist-btn btn btn-light" data-product-id="{{ $product->ID }}" data-color="{{$selectedColor}}" data-size="{{$selectedSize}}">
                                        <i class="fa fa-heart "></i>Add to wishlist
                                    </button>
                                    @else
                                    <button class="wishlist-btn btn btn-light" data-product-id="{{ $product->ID }}" data-color="{{$selectedColor}}" data-size="{{$selectedSize}}" disabled>
                                        <i class="fa fa-heart "></i>Add to wishlist
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- content-wraper end -->
        <!-- Begin Product Area -->
        <div class="product-area pt-35">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="li-product-tab">
                            <ul class="nav li-product-menu">

                                <li><a class="active" data-toggle="tab" href="#product-details"><span>Product
                                            Details</span></a></li>
                                <li><a data-toggle="tab" href="#reviews"><span>Reviews</span></a></li>
                            </ul>
                        </div>
                        <!-- Begin Li's Tab Menu Content Area -->
                    </div>
                </div>
                <div class="tab-content">
                    <div id="product-details" class="tab-pane active show" role="tabpanel">
                        <div class="product-description">
                            <span>{{ $product->Description }}</span>
                        </div>
                        <div class="product-details-manufacturer">
                        </div>
                    </div>
                    <div id="reviews" class="tab-pane" role="tabpanel">
                        @if (count($rating)>0)

                            <div class="product-reviews">
                                @foreach ($rating as $rat)
                                    <div class="product-details-comment-block">
                                        <div class="comment-review">
                                            <span>Rating</span>
                                            <ul class="rating rating-with-review-item">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $rat->Rating)
                                                        <li><i class="fa fa-star"></i></li>
                                                    @elseif(empty($rat->Rating))
                                                        <li><i class="fa fa-star-o"></i></li>
                                                    @else
                                                        <li><i class="fa fa-star-o"></i></li>
                                                    @endif
                                                @endfor
                                                <li>({{ $rat->Rating }})</li>
                                            </ul>
                                        </div>
                                        <div class="comment-author-infos pt-25">
                                            <span>By: {{ $rat->name }}</span>
                                            <em>{{ $rat->Order_Date }}</em>
                                        </div>
                                        <div class="comment-details">
                                            <h4 class="title-block">Feedback</h4>
                                            <p>{{ $rat->Feedback }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach

                            </div>


                        @else
                        <h3 class="text-center p-3">No reviews Available.</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <div class="product-area pt-30 pb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="li-product-tab">
                            <ul>
                                <li>
                                    <h4 data-toggle="tab"><span>Related Products</span></h4>
                                </li>
                            </ul>
                        </div>
                        <!-- Begin Li's Tab Menu Content Area -->
                    </div>
                </div>

                <div class="container py-4">
                    <div class="row">
                        @foreach ($relatedProducts as $product)
                            <div class="col-lg-3 col-md-6  col-12 mb-4">
                                <div class="single-product-wrap">
                                    <div class="product-image">
                                        <a href="{{ url('user/productdetail/' . $product->ID . '') }}">
                                            <img src="{{ asset('storage/' . $product->CoverImage) }}"
                                                alt="{{ $product->CoverImage }}">
                                        </a>
                                    </div>
                                    <div class="product_desc p-3">
                                        <div class="product_desc_info">
                                            <div class="product-review pb-5">
                                                <div class="rating-box ">
                                                    <ul class="rating rating-with-review-item">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $product->Rating)
                                                                <li><i class="fa fa-star"></i></li>
                                                            @elseif(empty($product->Rating))
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            @else
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            @endif
                                                        @endfor
                                                        @if (empty($product->Rating))
                                                            <li>
                                                                <p>(0)</p>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <p>({{ $product->total }})</p>
                                                            </li>
                                                        @endif

                                                    </ul>
                                                </div>
                                            </div>
                                            <h4><a class="product_name mt-1"
                                                    href="{{ url('user/productdetail/' . $product->ID . '') }}">{{ $product->Name }}</a>
                                            </h4>
                                            <div class="price-box py-2 ">
                                                <span class="new-price text-success">Rs:{{ $product->Price }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @push('script')
        <script>
            //variable for add to cart page
            $(document).ready(function() {
                // Handle color selection change
                $('input[name="colorof"]').val($('input[name="color"]:checked').val());
                $('input[name="sizeof"]').val($('input[name="size"]:checked').val());

                $('input[name="color"]').change(function() {
                    $('input[name="colorof"]').val($('input[name="color"]:checked').val());
                    updateStock();
                });

                // Handle size selection change
                $('input[name="size"]').change(function() {
                    $('input[name="sizeof"]').val($('input[name="size"]:checked').val());
                    updateStock();
                });

                // Function to update the stock using AJAX
                function updateStock() {
                    var selectedColor = $('input[name="color"]:checked').val();
                    var selectedSize = $('input[name="size"]:checked').val();
                    var productId = $('input[name="product_id"]').val();

                    // Get the CSRF token value
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    // Set the CSRF token in the AJAX headers
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    // Make the AJAX request
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('user/getstock') }}',
                        data: {
                            color: selectedColor,
                            size: selectedSize,
                            product_id: productId
                        },
                        success: function(response) {
                            //alert(data);
                            $('#avlstock').text(response.stock + ' Items Left!');
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                        }
                    });
                }
                selectedColor = $('input[name="color"]:checked').val();
                selectedSize = $('input[name="size"]:checked').val();

                // Update the stock based on the initial selected color and size
                updateStock();
            });
        </script>
    @endpush
    @endsection
    <!-- Product Area End Here -->






    <!---------------Models-------------->
    <!-- Begin Quick View | Modal Area -->
    <!--  <div class="modal fade modal-wrapper" id="mymodal">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-body">
                                                                                    <h3 class="review-page-title">Write Your Review</h3>
                                                                                    <div class="modal-inner-area row">
                                                                                        <div class="col-lg-6">
                                                                                            <div class="li-review-product">
                                                                                                <img src="images/product/large-size/3.jpg" alt="Li's Product">
                                                                                                <div class="li-review-product-desc">
                                                                                                    <p class="li-product-name">Today is a good day Framed
                                                                                                        poster
                                                                                                    </p>
                                                                                                    <p>
                                                                                                        <span>Beach Camera Exclusive Bundle - Includes Two
                                                                                                            Samsung
                                                                                                            Radiant 360 R3 Wi-Fi Bluetooth Speakers. Fill The
                                                                                                            Entire
                                                                                                            Room With Exquisite Sound via Ring Radiator
                                                                                                            Technology.
                                                                                                            Stream And Control R3 Speakers Wirelessly With Your
                                                                                                            Smartphone. Sophisticated, Modern Design </span>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-6">
                                                                                            <div class="li-review-content">

                                                                                                <div class="feedback-area">
                                                                                                    <div class="feedback">
                                                                                                        <h3 class="feedback-title">Our Feedback</h3>
                                                                                                        <form action="#">
                                                                                                            <p class="your-opinion">
                                                                                                                <label>Your Rating</label>
                                                                                                                <span>
                                                                                                                    <select class="star-rating">
                                                                                                                        <option value="1">1</option>
                                                                                                                        <option value="2">2</option>
                                                                                                                        <option value="3">3</option>
                                                                                                                        <option value="4">4</option>
                                                                                                                        <option value="5">5</option>
                                                                                                                    </select>
                                                                                                                </span>
                                                                                                            </p>
                                                                                                            <p class="feedback-form">
                                                                                                                <label for="feedback">Your Review</label>
                                                                                                                <textarea id="feedback" name="comment" cols="45" rows="8" aria-required="true"></textarea>
                                                                                                            </p>
                                                                                                            <div class="feedback-input">
                                                                                                                <p class="feedback-form-author">
                                                                                                                    <label for="author">Name<span
                                                                                                                            class="required">*</span>
                                                                                                                    </label>
                                                                                                                    <input id="author" name="author"
                                                                                                                        value="" size="30"
                                                                                                                        aria-required="true" type="text">
                                                                                                                </p>
                                                                                                                <p
                                                                                                                    class="feedback-form-author feedback-form-email">
                                                                                                                    <label for="email">Email<span
                                                                                                                            class="required">*</span>
                                                                                                                    </label>
                                                                                                                    <input id="email" name="email"
                                                                                                                        value="" size="30"
                                                                                                                        aria-required="true" type="text">
                                                                                                                    <span class="required"><sub>*</sub>
                                                                                                                        Required
                                                                                                                        fields</span>
                                                                                                                </p>
                                                                                                                <div class="feedback-btn pb-15">
                                                                                                                    <a href="#" class="close"
                                                                                                                        data-dismiss="modal"
                                                                                                                        aria-label="Close">Close</a>
                                                                                                                    <a href="#">Submit</a>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </form>
                                                                                                    </div>
                                                                                                </div>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>-->

