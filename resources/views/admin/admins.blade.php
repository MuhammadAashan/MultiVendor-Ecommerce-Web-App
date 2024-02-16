@extends('admin.masteradmin')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-6  align-items-center">
                <h4 class="page-title">Admin List</h4>
                @if ($errors->count() > 0)
                    @foreach ($errors->all() as $message)
                        <p class="text-danger">{{ $message }}</p>
                    @endforeach
                @endif
            </div>
            <div class="col-6 text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadmin"><i
                        class="fas fa-plus"></i> New Admin</button>
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
                            <form method="GET" action="{{ url('admin/admins') }}">
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
                            <table class="table  table-hover table-light ">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>MobileNo</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>
                                @foreach ($admindata as $cd)
                                    <tbody>


                                        <td>{{ $cd->name }}</td>
                                        <td>{{ $cd->email }}</td>
                                        <td>{{ $cd->mobileno }}</td>
                                        <td>{{ $cd->role }}</td>
                                        <td>
                                            @if ($cd->role == 'mainadmin')
                                                <button type="button" class="btn btn-primary" data-id="{{ $cd->id }}"
                                                    data-name="{{ $cd->name }}" data-email="{{ $cd->email }}"
                                                    data-mobileno="{{ $cd->mobileno }}" data-password="{{ $cd->password }}"
                                                    data-role="{{ $cd->role }}" data-toggle="modal"
                                                    data-target="#editadminmodel"><i class=" far fa-edit"></i></button>
                                            @else
                                                <button type="button" class="btn btn-primary"
                                                    data-id="{{ $cd->id }}" data-name="{{ $cd->name }}"
                                                    data-email="{{ $cd->email }}" data-mobileno="{{ $cd->mobileno }}"
                                                    data-password="{{ $cd->password }}" data-role="{{ $cd->role }}"
                                                    data-toggle="modal" data-target="#editadminmodel"><i
                                                        class=" far fa-edit"></i></button>
                                                <button type="button" class="btn btn-danger m-1"
                                                    data-catid="{{ $cd->id }}"data-toggle="modal"
                                                    data-target="#demoModal"><i class=" far fa-trash-alt"></i></button>
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

    <!----------Models--------------->
    <!--------Model to add admin----------------------------->
    <form action="/admin/addadmin" method="post">
        @csrf
        <div class="modal fade" id="addadmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Admin</h5>
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
                            <label for="email" class="col-form-label">Email *</label>
                            <input type="text" class="form-control" name="email" id="email"
                                placeholder="Please enter Email">

                        </div>
                        <div class="form-group">
                            <label for="mobileno" class="col-form-label">MobileNo *</label>
                            <input type="text" class="form-control" name="mobileno" id="mobileno"
                                placeholder="Please enter Mobile No">

                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">Password *</label>
                            <input type="text" class="form-control" name="password" id="password"
                                placeholder="Please enter Password">

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


    <!----------------------------Model to edit admin---------------------------------->
    <form action="/admin/editadmin" method="post">
        @csrf
        <div class="modal fade" id="editadminmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit
                            Admin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="form-group">
                            <label for="id" class="col-form-label">AdminID</label>
                            <input type="text" class="form-control" name="id" id="id">

                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name">

                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email</label>
                            <input type="text" class="form-control" name="email" id="email">

                        </div>
                        <div class="form-group">
                            <label for="mobileno" class="col-form-label">MobileNo</label>
                            <input type="text" class="form-control" name="mobileno" id="mobileno">

                        </div>
                        <div class="form-group">
                            <label for="role">Admin Role</label>
                            <select name="role" id="role">
                                <option value="mainadmin">Main Admin</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">

                            <input type="hidden" class="form-control" name="password" id="password" >

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
    <!-------------------------model for remove admin---------------------->
    <form action="/admin/removeadmin" method="post">
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
                        <p>Are you sure to remove this admin?</p>
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
