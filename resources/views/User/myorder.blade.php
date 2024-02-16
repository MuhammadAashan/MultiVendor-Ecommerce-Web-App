@extends('User.masteruser')
@section('content')
   <!-- <style>
        .button {
            float: left;
            margin: 0 5px 0 0;
            width: 120px;
            height: 60px;
            position: relative;
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

        .button input[type="radio"]:checked+label {
            background: green;
            border-radius: 10px;
            color: white;
        }

        .button label {
            cursor: pointer;
            z-index: 90;
            line-height: 20px;
        }
    </style>-->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ url('user/dashboard') }}">Home</a></li>
                    <li class="active">My Orders</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center mt-3 mb-1">My Orders</h3>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-10 offset-1">
                <!-- <div class="card mb-5">
                        <div class="card-body">
                          <div class="text-right mb-3">

                            <h5 class="text-center">My Orders</h5>

                                <div class="row">
                                    <div class="col-12 text-right">
                                        <div class="form-group ">
                                            <div class="button">
                                                <input type="radio" id="pl" name="status" value="placed" checked>
                                                <label for="pl" class="p-2"> Active Orders</label>
                                            </div>
                                            <div class="button">
                                                <input type="radio" name="status" id="dl" value="delivered">
                                                <label for="dl" class="p-2">Delivered Orders</label>
                                            </div>
                                            <div class="button">
                                                <input type="radio" name="status" id="cl" value="cancelled">
                                                <label for="cl" class="p-2"> Cancelled Orders</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->

                <div class="row">
                    @php
                        $prevOrderId = null;
                    @endphp

                    @foreach ($orderdata as $order)
                        @if ($order->Id != $prevOrderId)
                            <div class="col-md-6">
                                <div class="card mb-3" id="card">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-body">

                                                <h5 class="card-title">Order No: {{ $order->Id }}</h5>

                                                <p class="card-text">Total Bill: Rs {{ $order->TotalBill }}</p>
                                                <p class="card-text">Delivery Address: {{ $order->DeliveryAddress }}</p>
                                                <p class="card-text">Order Date: {{ \Carbon\Carbon::parse($order->Order_Date)->format('Y-F-d h:i A') }}</p>
                                                <div class="row card-text">

                                                    @foreach ($orderdata as $product)
                                                        @if ($product->Id == $order->Id)
                                                            <div class="col-3">
                                                                <a href="{{ url('user/productdetail/' . $product->product_id) }}">
                                                                    <img width="100px" src="{{ asset('storage/' . $product->productimage) }}"
                                                                        alt="{{ $product->productimage }}" class="img-fluid">
                                                                </a>
                                                                <p class="text-primary">Status: <span class="text-danger">{{ $product->Status }}</span></p>
                                                            </div>
                                                        @endif
                                                    @endforeach

                                                </div>

                                                <form action="{{ url('user/vieworder') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" class="form-control" name="id" id="id" value="{{ $order->Id }}">
                                                    <button type="submit" class="btn btn-success"><i class="fa fa-eye"></i> Details</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @php
                            $prevOrderId = $order->Id;
                        @endphp
                    @endforeach
                </div>



            </div>
        @endsection

        @push('script')
            <!--<script>
                $(document).ready(function() {
                    // Show active orders by default
                    showOrders('placed');

                    // Event handler for radio button change
                    $('input[name="status"]').on('change', function() {
                        var status = $(this).val();
                        showOrders(status);
                    });

                    // Function to show orders based on status
                    function showOrders(status) {
                        // Hide all order cards
                        $('#card').hide();

                        // Show order cards with the matching status class
                        $('.' + status + '-order').parent('#card').show();
                    }
                });
            </script>
    -->
        @endpush
