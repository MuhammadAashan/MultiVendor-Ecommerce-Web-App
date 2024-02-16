@extends('seller.masterseller')
@section('content')

    <div class="page-breadcrumb">
        <div class="row ">
            <div class="col-6 mb-2  align-items-center">
                <h4 class="page-title">Order List</h4>
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
                <!------+++++++++++++++++++++++++++++++++++-->
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-5">
                            <form method="GET" action="{{ url('seller/order') }}">
                                <div class="input-group  bg-dark p-1">
                                    <input type="text" id="search" name="search"
                                        placeholder="Search Order Id,Product & Address" value="{{ Session::get('search') }}"
                                        class="form-control ">
                                    <div class="input-group-append">
                                        <button class="input-group-text bg-light" id="basic-addon4"><i
                                                class=" fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <hr>
                        <div class="table-responsive ">
                            <table class="table table-hover table-light">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Order No</th>
                                        <th>Customer Name</th>
                                        <th>No of product in order</th>
                                        <th>Delivery Address</th>
                                        <th>Total Bill</th>
                                        <th>Order_Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($orders) > 0)
                                        @foreach ($orders as $cd)
                                            <tr>
                                                <td style="text-align: center; vertical-align: middle;">{{ $cd->Id }}
                                                </td>
                                                <td style="text-align: center; vertical-align: middle;">{{ $cd->name }}
                                                </td>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    {{ $cd->productcount }}</td>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    {{ $cd->DeliveryAddress }}</td>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    Rs:{{ $cd->TotalBill }}</td>
                                                <td style="text-align: center; vertical-align: middle;">
                                                    {{ $cd->Order_Date }}</td>
                                                <td style="text-align: center; vertical-align: middle;"><a
                                                        class="btn btn-primary"
                                                        href="{{ url('seller/vieworder/' . $cd->Id) }}"><i
                                                            class="fas fa-eye"></i></a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <p>No Orders Found!</p>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    @endsection
