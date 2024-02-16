@extends('admin.masteradmin')
@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add Category</h4>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row m-5">
            <div class="col-12">

                <form action="addedcategory" method="post">
                    @csrf
                    <h2 class="text-center mb-3">Add Category</h2>

                    <div class="form-outline mb-4">
                        <input type="text" id="catname" name="catname" value="{{ old('catname')}}"
                            class="form-control form-control-lg rounded-pill" placeholder="Please Enter Category name" / required>
                            @if ( $errors->count() > 0 )

                                @foreach( $errors->all() as $message )
                                <p class="text-danger">{{ $message }}</p>
                                @endforeach

                            @endif

                    </div>
                    <div class="form-outline mb-4">
                    <textarea rows="4"  class="form-control form-control-lg rounded-pill" data-validation="required" cols="50" name="catdesc" id="catdesc" placeholder=" Write about Category Description in details" /required></textarea>
                   </div>
                    <div class="p-2 mb-4 mx-">
                        <button class="btn rounded-pill bg-danger text-light" type="submit"
                            style="background-color: black;">Add</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
