@extends('admin.masteradmin')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-6  align-items-center">
                <h4 class="page-title">Customer List</h4>
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


                <div class="card">
                    <div class="card-body">
                        <!------Search------>
                        <div class="col-md-5">
                            <form method="GET" action="{{ url('admin/customer') }}">
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
                                        <th>Email</th>
                                        <th>MobileNo</th>
                                        <th>Address</th>
                                        <th>Detail</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>
                                @foreach ($customerdata as $cd)
                                    <tbody>
                                        @csrf
                                        <td>{{ $cd->name }}</td>
                                        <td>{{ $cd->email }}</td>
                                        <td>{{ $cd->mobileno }}</td>
                                        <td>{{ $cd->address }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success m-1 mt-1"
                                                data-sellerid="{{ $cd->id }}" data-sellername="{{ $cd->name }}"
                                                data-selleremail="{{ $cd->email }}"
                                                data-sellermobileno="{{ $cd->mobileno }}"
                                                data-selleraddress="{{ $cd->address }}" data-toggle="modal"
                                                data-target="#viewseller">
                                                <i class="fas fa-eye"></i></button>
                                        </td>
                                        <td>

                                            <button type="button" class="btn btn-danger m-1"
                                                data-catid="{{ $cd->id }}" data-toggle="modal"
                                                data-target="#demoModal">Remove</button>
                                        </td>
                                    </tbody>







                                    <!-------Model for detial button--------->

                                    <div class="modal" tabindex="-1" role="alertdialog" id="viewseller">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Customer Detail</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <label for="sellerid" class="col-form-label">Customer
                                                                    ID</label>
                                                                <input type="text" class="form-control" name="sellerid"
                                                                    id="sellerid" value="{{ $cd->id }}" disabled>
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="sellername" class="col-form-label">Name</label>
                                                                <input type="text" class="form-control" name="sellername"
                                                                    id="sellername" value="{{ $cd->name }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">

                                                            <label for="selleremail" class="col-form-label">Email</label>
                                                            <input type="text" class="form-control" name="selleremail"
                                                                id="selleremail" value="{{ $cd->email }}" disabled>

                                                        </div>
                                                        <div class="form-group">

                                                            <label for="sellermobileno" class="col-form-label">Mobile
                                                                No</label>
                                                            <input type="text" class="form-control" name="sellermobileno"
                                                                id="sellermobileno" value="{{ $cd->mobileno }}" disabled>

                                                        </div>


                                                    </div>
                                                    <div class="form-group">
                                                        <label for="selleraddress" class="col-form-label">Address</label>
                                                        <textarea class="form-control" name="selleraddress" id="selleraddress" disabled>{{ $cd->address }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!----------------------------->


    <!-------------------remove customer model names demo model----------------------------->
    <form action="/admin/removecustomer" method="post">
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
                        <p>Are you sure to remove this customer?</p>
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
