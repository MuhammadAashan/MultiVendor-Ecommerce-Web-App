@extends('seller.masterseller')
@section('content')



    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-4  align-items-center">
                <h4 class="page-title">Complaint </h4>
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

                                        <th>Customer_Name</th>
                                        <th>Product_ID</th>
                                        <!-- <th>Product Name</th>
                                            <th>Image</th>-->
                                        <th>Complaint Description</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @if (count($complaint) > 0)
                                    @foreach ($complaint as $com)
                                        <tbody>

                                            <td>{{ $com->name }}</td>
                                            <td>{{ $com->Product_Id }}</td>
                                            <!-- <td>{ $com->prodname}}</td>
                                                <td><img src="{ asset('storage/' . $com->CoverImage) }}" alt="image"
                                                    width="50px" /></td>-->
                                            <td>{{ $com->Description }}</td>
                                            <td>{{ $com->Creation_at }}</td>
                                            <td>
                                                <form action="/seller/viewcomplaints" method="post">
                                                    @csrf
                                                    <input type="hidden" class="form-control catid" name="id"
                                                        id="id" value="{{ $com->Id }}">
                                                    <button type="submit" class="btn btn-danger m-1"><i
                                                            class="fas fa-eye"></i> Detail</button>
                                                </form>
                                            </td>

                                        </tbody>
                                    @endforeach
                                @else
                                    <h3>No Complaint found!</h3>
                                @endif

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
