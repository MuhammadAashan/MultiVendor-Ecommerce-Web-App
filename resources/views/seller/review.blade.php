@extends('seller.masterseller')
@section('content')



<div class="page-breadcrumb">
    <div class="row">
        <div class="col-4  align-items-center">
            <h4 class="page-title">Reviews </h4>
            @if ( $errors->count() > 0 )

            @foreach( $errors->all() as $message )
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
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (count($review)>0)
                                @foreach ($review as $cd)
                            <tr>
                                <td>{{ $cd->name }}</td>
                                <td>{{ $cd->Product_Id }}</td>
                                <td>{{ $cd->Feedback }}</td>
                                <td><i class="fa fa-star"></i> ({{ $cd->Rating }})</td>
                                <td>
                                    <form action="/seller/viewreviews" method="post">
                                        @csrf
                                        <input type="hidden" class="form-control catid" name="id"
                                            id="id" value="{{ $cd->Order_Id }}">
                                        <button type="submit" class="btn btn-success m-1"><i
                                                class="fas fa-eye"></i> Details</button>
                                    </form>
                                </td>
                            </tr>
                                @endforeach
                                @else
                                <h5 class="text-center"> No Reviews Found!</h5>
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
