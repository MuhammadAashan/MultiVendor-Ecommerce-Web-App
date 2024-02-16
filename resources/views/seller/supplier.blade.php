@extends('seller.masterseller')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-6  align-items-center">
                <h4 class="page-title">Supplier List</h4>
                @if ($errors->count() > 0)
                    @foreach ($errors->all() as $message)
                        <p class="text-danger">{{ $message }}</p>
                    @endforeach
                @endif
            </div>
            <div class="col-6 text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadmin"><i
                        class="fas fa-plus"></i> Add Supplier</button>
            </div>
        </div>
    </div>


    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">


                <div class="card">
                    <div class="card-body">
                        <div class="col-md-5">
                            <form method="GET" action="{{ url('seller/supplier') }}">
                                <div class="input-group  bg-dark p-1">
                                    <input type="text" id="search" name="search" placeholder="Type & Enter"
                                        value="{{ Session::get('search') }}" class="form-control ">
                                    <div class="input-group-append">
                                        <button class="input-group-text bg-light" id="basic-addon4"><i
                                                class=" fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="zero_config" class="table  table-hover table-light ">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Name</th>
                                        <th>MobileNo</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>

                                <tbody>
                                    @if (count($supplierdata) > 0)
                                        @foreach ($supplierdata as $cd)
                                            <tr>

                                                <!--                        <td> <form action="/admin/sellerdetail" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" id="ID" name="ID" value="$cd->ID}}" >
                                                  </div>
                                                <button type="submit" class="btn m-1" ><i class="bi bi-caret-down"></i></button>
                                            </form></td-->
                                                <td>{{ $cd->Name }}</td>
                                                <td>{{ $cd->MobileNo }}</td>
                                                <td>{{ $cd->Address }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary"
                                                        data-id="{{ $cd->Id }}" data-name="{{ $cd->Name }}"
                                                        data-mobileno="{{ $cd->MobileNo }}"
                                                        data-address="{{ $cd->Address }}" data-toggle="modal"
                                                        data-target="#editsuppliermodel"><i
                                                            class=" far fa-edit"></i></button>
                                                    <!-- <button type="button" class="btn btn-danger m-1"
                                                    data-catid="{ $cd->Id }}"data-toggle="modal"
                                                    data-target="#demoModal"><i class=" far fa-trash-alt"></i></button>
                                               -->
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <p>No Supplier found!</p>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!------------------_____________________________---------------------->
    <!------------------------model to add supplier------------------------->

    <form action="/seller/addsupplier" method="post">
        @csrf
        <div class="modal fade" id="addadmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Supplier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name *</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Please enter Name">

                        </div>
                        <div class="form-group">
                            <label for="mobileno" class="col-form-label">MobileNo *</label>
                            <input type="text" class="form-control" name="mobileno" id="mobileno"
                                placeholder="Please enter Mobile No">

                        </div>
                        <div class="form-group">
                            <label for="address" class="col-form-label">Address *</label>
                            <input type="text" class="form-control" name="address" id="address"
                                placeholder="Please enter Address">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-------------------------model to edit supplier------------------------------->
    <form action="/seller/editsupplier" method="post">
        @csrf
        <div class="modal fade" id="editsuppliermodel" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit
                            Supplier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="id" id="id">
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name">

                        </div>
                        <div class="form-group">
                            <label for="mobileno" class="col-form-label">MobileNo</label>
                            <input type="text" class="form-control" name="mobileno" id="mobileno">

                        </div>
                        <div class="form-group">
                            <label for="address" class="col-form-label">Address</label>
                            <input type="text" class="form-control" name="address" id="address">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save
                            Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!----------------------------model to remove supplier----------------------------------------->
    <form action="/seller/removesupplier" method="post">
        @csrf
        <div class="modal" tabindex="-1" role="alertdialog" id="demoModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Warning!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to remove this supplier?</p>
                        <div class="form-group">
                            <input type="hidden" class="form-control " name="ID" id="ID">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Yes</button></a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
