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
                                <h3>Add Product</h3>
                            </div>
                            @if ($errors->count() > 0)
                                @foreach ($errors->all() as $message)
                                    <p class="text-danger">{{ $message }}</p>
                                @endforeach
                            @endif
                            <div class="card-body">
                                <form action="/seller/productadded" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        @foreach ($shop as $cd)
                                            <input type="hidden" name="shop" id="shop" value="{{ $cd->ID }}">
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter Product Name">
                                        <div class="invalid-feedback">Product Name Can't Be Empty</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="desc">Product Description</label>
                                        <textarea type="text" class="form-control" id="desc" name="desc" placeholder="Enter Product Detail"></textarea>
                                        <div class="invalid-feedback">Product Description Can't Be Empty</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="maincat">Choose Category</label>
                                        <select name="maincat" id="maincat">
                                            @php
                                                $uniqueCategories = $catdata->unique('categoryname');
                                            @endphp

                                            @foreach ($uniqueCategories as $category)
                                                <option value="{{ $category->categoryid }}">{{ $category->categoryname }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="cat">Choose SubCategory</label>
                                        <select name="cat" id="cat">
                                            <option value="">--Select SubCategory--</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="price">Product Cost</label>
                                        <input type="text" class="form-control" id="cost" name="cost"
                                            placeholder="Enter Product Cost">
                                        <div class="invalid-feedback">Product Price Can't Be Empty</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Product Selling Price</label>
                                        <input type="text" class="form-control" id="price" name="price"
                                            placeholder="Enter Product selling Price">
                                        <div class="invalid-feedback">Product Price Can't Be Empty</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="productimage">Product Cover Image</label>
                                        <input type="file" id="productimage" name="productimage">
                                        <div class="invalid-feedback">File Format Not Supported</div>
                                    </div>

                                    <div class="form-group">
                                        <label for="productimage1">Product Other Images</label>
                                        <input type="file" class="btn" id="productimage1" name="productimage1[]"
                                            multiple>
                                        <small for="productimage1">You can Choice Multiple Images</small>
                                    </div>
                                    <button class="btn btn-dark mt-5 mx-auto d-block" type="submit">Add
                                        Product</button>
                                </form>
                            </div>
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
