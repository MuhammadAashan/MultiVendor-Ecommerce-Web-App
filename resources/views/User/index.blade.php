@extends('User.masteruser')
@section('content')

    <!-- Begin Product Area -->
    <div class="product-area pt-30 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="li-product-tab">
                        <ul class="nav li-product-menu">
                            <li>
                                <h4 data-toggle="tab"><span>Recommended Products</span></h4>
                            </li>
                        </ul>
                    </div>
                    <!-- Begin Li's Tab Menu Content Area -->
                </div>
            </div>
            <div class="container py-4">
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 mb-4">
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
                                                            <p>({{ $product->Rating }})</p>
                                                        </li>
                                                    @endif

                                                </ul>
                                            </div>
                                        </div>
                                        <h4><a class="product_name"
                                                href="{{ url('user/productdetail/' . $product->ID . '') }}">{{ $product->Name }}</a>
                                        </h4>
                                        <div class="price-box py-2 ">
                                            <h3><span class="new-price text-success ">Rs:{{ $product->Price }}</span></h3>
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

    <!-- Product Area End Here -->
@endsection
