@extends('seller.masterseller')
@section('content')


    <div class="page-breadcrumb">
        <div class="row ">
            <div class="col-6 mb-2  align-items-center">
                <h4 class="page-title">Order Detail</h4>
                @if ($errors->count() > 0)
                    @foreach ($errors->all() as $message)
                        <p class="text-danger">{{ $message }}</p>
                    @endforeach
                @endif
            </div>


        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <a href="{{ url('seller/dashboard') }}" class="btn text-light bg-primary">Back</a>
                        <div class="text-right mb-3">
                            @php
                                $prevOrderId = null; // Variable to store the previous Order_Id
                            @endphp
                            @foreach ($vieworder as $cd)
                                @if ($cd->Order_Id != $prevOrderId)
                                    <h5>Order No: {{ $cd->Order_Id }}</h5>
                                    <h6>Order Date: {{ strftime('%Y-%B-%d', strtotime($cd->Order_Date)) }}</h6>
                                    <h6>Email Address: {{$cd->email}}</h6>
                                    <p>Contact No: {{$cd->mobileno}}</p>
                                    @php
                                        $prevOrderId = $cd->Order_Id; // Update the previous Order_Id
                                    @endphp
                                @endif
                            @endforeach
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-tranparent">
                                <thead>
                                    <th>Product Image</th>
                                    <th>Product No</th>
                                    <th>Product Name</th>
                                    <th>Product Variation</th>
                                    <th>Product Quantity</th>
                                    <th>Product Price</th>

                                </thead>
                                <tbody>
                                    @foreach ($vieworder as $cd)
                                        <tr>

                                            <td class="text-center">
                                                <a href="{{ url('user/productdetail/' . $cd->ID) }}">
                                                    <img width="150px" src="{{ asset('storage/' . $cd->CoverImage) }}"
                                                        alt="{{ $cd->CoverImage }}" class="img-fluid">
                                                </a>
                                            </td>
                                            <td>{{ $cd->ID }}</td>

                                            <td>{{ $cd->Name }}</td>
                                            <td>Color: {{ $cd->Product_Color }} & Size: {{ $cd->Product_Size }}</td>
                                            <td>Quantity: {{ $cd->Quantity }}</td>
                                            <td>{{$cd->Purchase_Price}}</td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                                <h4 class="mx-3 text-right">Total Amount: RS. {{$cd->TotalBill}}</h4>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
