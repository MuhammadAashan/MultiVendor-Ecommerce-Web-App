@extends('admin.masteradmin')
@section('content')
    @if ($data == '')
        @foreach ($data as $cd)
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">No data found!</h4>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        @foreach ($data as $cd)
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-6 d-flex no-block align-items-center">
                        <h4 class="page-title text-primary"> Order ID: {{ $cd->Order_Id }}</h4>
                    </div>
                    <div class="col-6 text-right"><a href="{{url('admin/review')}}" class="btn btn-primary">Back</a></div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row ">

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-12 border-right">
                                        <h4 class="text-danger">Product Name: {{ $cd->Productname }}</h4>
                                        <br>
                                        <p>Product Description: {{ $cd->Description }}</p>
                                        <img src="{{ asset('storage/' . $cd->CoverImage) }}" width="50%" alt="">
                                    </div>
                                    <hr>
                                    <div class="col-md-6 col-12">
                                        <h4 class="text-primary">Seller Name: {{ $cd->Name }}</h4>
                                        <h5 class="text-dark">Order Date: {{ $cd->Order_Date }}</h5>
                                        <h4 class="text-dark">Product Price: {{ $cd->Price }}</h4>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
