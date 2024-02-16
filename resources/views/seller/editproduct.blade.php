@extends('seller.masterseller')
@section('content')

    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row ">
            <div class="col-12 ml-auto">
                <div class="row align-items-center mb-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-title text-center mt-3">
                                <h3>Edit Product</h3>
                            </div>
                            @if ($errors->count() > 0)
                                @foreach ($errors->all() as $message)
                                    <p class="text-danger">{{ $message }}</p>
                                @endforeach
                            @endif
                            @foreach($productdata as $cd)
                            <div class="card-body">
                                <form action="/seller/editproduct" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="hidden" class="form-control" id="id" name="id" value="{{$cd->ID}}">
                                        <input type="text" class="form-control" id="name" name="name" value="{{$cd->Name}}">
                                        <div class="invalid-feedback">Product Name Can't Be Empty</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="desc">Product Description</label>
                                        <textarea type="text" class="form-control" id="desc" name="desc">{{$cd->Description}}</textarea>
                                        <div class="invalid-feedback">Product Description Can't Be Empty</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="maincat">Choose Category</label>
                                        <select name="maincat" id="maincat" >
                                            @foreach ($uniqueCategories as $category)
                                                <option value="{{ $category->categoryid }}" {{ $category->categoryid == $cd->Subcategory_Id ? 'selected' : '' }}>
                                                    {{ $category->categoryname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="cat">Choose Subcategory</label>
                                        <select name="cat" id="cat">
                                            @foreach ($subcategories as $subcategory)
                                                <option value="{{ $subcategory->Id }}" {{ $subcategory->Id == $cd->Subcategory_Id ? 'selected' : '' }}>
                                                    {{ $subcategory->Name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="price">Product Cost</label>
                                        <input type="text" class="form-control" id="cost" name="cost" value="{{$cd->Cost}}">
                                        <div class="invalid-feedback">Product Price Can't Be Empty</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Product Selling Price</label>
                                        <input type="text" class="form-control" id="price" name="price" value="{{$cd->Price}}">
                                        <div class="invalid-feedback">Product Price Can't Be Empty</div>
                                    </div>
                                    <button class="btn btn-dark mt-5 mx-auto d-block" type="submit">Update Product</button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#maincat').change(function() {
            var selectedCategory = $(this).val();
            var subcategories = @json($catdata);

            // Clear existing subcategory options
            $('#cat').empty();

            // Filter subcategories based on the selected category
            var filteredSubcategories = subcategories.filter(function(subcategory) {
                return subcategory.categoryid == selectedCategory;
            });

            // Add options for filtered subcategories
            $.each(filteredSubcategories, function(index, subcategory) {
                var option = $('<option>')
                    .val(subcategory.Id)
                    .text(subcategory.Name);
                $('#cat').append(option);
            });
        });
    });
</script>
@endpush
