@extends('admin.masteradmin')
@section('content')



    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-4  align-items-center">
                <h4 class="page-title">Sizes List</h4>
                @if ($errors->count() > 0)
                    @foreach ($errors->all() as $message)
                        <p class="text-danger">{{ $message }}</p>
                    @endforeach
                @endif
            </div>
            <div class="col-8 text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addmodel"><i
                        class="fas fa-plus"></i> Size</button>
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
                        <!----Search----->
                        <div class="col-md-5">
                            <form method="GET" action="{{url('admin/size')}}">
                                <div class="input-group  bg-dark p-1">
                                    <input type="text" id="search" name="search" placeholder="Type & Enter to search category or subcategory"  value="{{ Session::get('search') }}" class="form-control " >
                                    <div class="input-group-append">
                                        <button class="input-group-text bg-light" id="basic-addon4"><i class=" fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <hr>
                        <div class="table-responsive ">
                            <table class="table table-hover table-light text-center">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Category</th>
                                        <th>Subcategory</th>
                                        <th>Size</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ($sizelist as $cd)
                                    <tbody>
                                        <td>{{ $cd->categoryname }}</td>
                                        <td>{{ $cd->subcategoryname }}</td>
                                        <td>{{ $cd->Name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary m-1"
                                                data-catid="{{ $cd->ID }}" data-catname="{{ $cd->Name }}"
                                                data-toggle="modal" data-target="#editmodel"><i
                                                    class=" far fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger m-1"
                                                data-catid="{{ $cd->ID }}" data-toggle="modal"
                                                data-target="#demoModal"><i class=" far fa-trash-alt"></i></button>

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




<!--__________________________________________________________________-->

<!----------------------------------------------->
<!---------------model to add size---------------------->
<form action="/admin/addsize" method="post">
    @csrf
    <div class="modal fade" id="addmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Size</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                    <div class="form-group">
                        <label for="cat">Choose Category</label>
                        <select name="cat" id="cat">
                            @if ($categorydata == '')
                            @else
                                @foreach ($subcategorydata as $cat)
                                    <option value="{{ $cat->Id }}">
                                        {{ $cat->maincategoryname . '--' . $cat->Name }}</option>
                                @endforeach
                            @endif

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="catname" class="col-form-label">Size</label>
                        <input type="text" class="form-control" name="catname" id="catname">
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
<!-------Model for delete button--------->
<form action="/admin/deletesize" method="post">
    @csrf
    <div class="modal" tabindex="-1" role="alertdialog" id="demoModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Warning!</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete this Size?</p>
                    <div class="form-group">
                        <input type="hidden" class="form-control catid" name="catidp"
                            id="catidp">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Yes</button></a>
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!----------Model for edit button------------>
<form action="/admin/editsize" method="post">
    @csrf
    <div class="modal fade" id="editmodel" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Size</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">

                        <input type="hidden" class="form-control" name="catid"
                            id="catid">
                    </div>
                    <div class="form-group">
                        <label for="catname" class="col-form-label">Size</label>
                        <input type="text" class="form-control" name="catname"
                            id="catname">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
