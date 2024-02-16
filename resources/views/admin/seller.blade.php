@extends('admin.masteradmin')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-6  align-items-center">
                <h4 class="page-title">Sellers List</h4>
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
                        <!-----Search bar----->
                        <div class="col-md-5">
                            <form method="GET" action="{{ url('admin/seller') }}">
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
                                        <th>Seller Name</th>
                                        <th>Shop Name</th>
                                        <th>Shop Description</th>
                                        <th>Status</th>
                                        <th>Detail</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>
                                @foreach ($sellerdata as $cd)
                                    <tbody>

                                        <!--                        <td> <form action="/admin/sellerdetail" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" id="ID" name="ID" value="$cd->ID}}" >
                                                  </div>
                                                <button type="submit" class="btn m-1" ><i class="bi bi-caret-down"></i></button>
                                            </form></td-->
                                        <td>{{ $cd->sellername }}</td>
                                        <td>{{ $cd->Name }}</td>
                                        <td>{{ $cd->Description }}</td>
                                        <td>{{ $cd->status }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success my-auto"
                                                data-sellerid="{{ $cd->Seller_Id }}" data-sellername="{{ $cd->sellername }}"
                                                data-selleremail="{{ $cd->selleremail }}"
                                                data-sellercnic="{{ $cd->sellercnic }}"
                                                data-sellermobileno="{{ $cd->sellermobileno }}"
                                                data-selleraddress="{{ $cd->selleraddress }}" data-toggle="modal"
                                                data-target="#viewseller">
                                                <i class="fas fa-eye"></i></button>
                                        </td>
                                        <td>
                                            @if ($cd->status == 'pending')
                                                <form action="/admin/approveseller" method="post">
                                                    @csrf
                                                    <div>
                                                        <input type="hidden" id="ID" name="ID"
                                                            value="{{ $cd->ID }}">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary my-auto">Approve</button>
                                                </form>
                                            @elseif($cd->status == 'Approved')
                                                <form action="/admin/blockseller" method="post">
                                                    @csrf
                                                    <div>
                                                        <input type="hidden" id="ID" name="ID"
                                                            value="{{ $cd->ID }}">
                                                    </div>
                                                    <button type="submit" class="btn btn-danger my-auto">Block</button>
                                                </form>
                                            @elseif($cd->status == 'Block')
                                                <form action="/admin/approveseller" method="post">
                                                    @csrf
                                                    <div>
                                                        <input type="hidden" id="ID" name="ID"
                                                            value="{{ $cd->ID }}">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary my-auto">Approve</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tbody>
                                @endforeach

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!------------------------------------------------------->
    <!-----------------model for detail button------------------->


    <div class="modal" tabindex="-1" role="alertdialog" id="viewseller">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seller Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="sellerid" class="col-form-label">Seller
                                    ID</label>
                                <input type="text" class="form-control" name="sellerid" id="sellerid"
                                    value="{{ $cd->Seller_Id }}" disabled>
                            </div>
                            <div class="col-6">
                                <label for="sellername" class="col-form-label">Name</label>
                                <input type="text" class="form-control" name="sellername" id="sellername"
                                    value="{{ $cd->sellername }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">

                            <label for="selleremail" class="col-form-label">Email</label>
                            <input type="text" class="form-control" name="selleremail" id="selleremail"
                                value="{{ $cd->selleremail }}" disabled>

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <label for="sellercnic" class="col-form-label">CNIC</label>
                                    <input type="text" class="form-control" name="sellercnic" id="sellercnic"
                                        value="{{ $cd->sellercnic }}" disabled>
                                </div>
                                <div class="col-6">
                                    <label for="sellermobileno" class="col-form-label">Mobile No</label>
                                    <input type="text" class="form-control" name="sellermobileno" id="sellermobileno"
                                        value="{{ $cd->sellermobileno }}" disabled>
                                </div>
                            </div>


                        </div>
                        <div class="form-group">
                            <label for="selleraddress" class="col-form-label">Address</label>
                            <textarea class="form-control" name="selleraddress" id="selleraddress" disabled>{{ $cd->selleraddress }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
