@extends('seller.masterseller')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-4  align-items-center">
                <h4 class="page-title">Stock Summary </h4>
                @if ($errors->count() > 0)
                    @foreach ($errors->all() as $message)
                        <p class="text-danger">{{ $message }}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <!------+++++++++++++++++++++++++++++++++++-->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="zero_config" class="table table-hover table-light">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Product_ID</th>
                                        <th>Product Name</th>
                                        <th>Total Stock</th>
                                        <th>Sold Stock</th>
                                        <th>Available Stock</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($data)>0)
                                    @foreach ($data as $cd)
                                    <tr>
                                        <td>{{$cd->ID}}</td>
                                        <td>{{$cd->Name}}</td>
                                        <td>{{$cd->totalStock}}</td>
                                        <td>{{$cd->totalSold}}</td>
                                        <td>{{$cd->totalStock-$cd->totalSold}}</td>
                                    </tr>

                                    @endforeach
                                    @else
                                    <tr><p>No Stock Availble</p></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
