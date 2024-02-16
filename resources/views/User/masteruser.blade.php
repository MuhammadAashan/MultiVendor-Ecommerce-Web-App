<!doctype html>
<html class="no-js" lang="zxx">

<!-- index28:48-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Estore Multi-Vendor Ecommerce plateform</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('favicon.ico') }}">
    <!-- Material Design Iconic Font-V2.2.0 -->
    <link rel="stylesheet" href="{{ url('css/material-design-iconic-font.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('css/font-awesome.min.css') }}">
    <!-- Font Awesome Stars-->
    <link rel="stylesheet" href="{{ url('css/fontawesome-stars.css') }}">
    <!-- Meanmenu CSS -->
    <link rel="stylesheet" href="{{ url('css/meanmenu.css') }}">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="{{ url('css/owl.carousel.min.css') }}">
    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" href="{{ url('css/slick.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ url('css/animate.css') }}">
    <!-- Jquery-ui CSS -->
    <link rel="stylesheet" href="{{ url('css/jquery-ui.min.css') }}">
    <!-- Venobox CSS -->
    <link rel="stylesheet" href="{{ url('css/venobox.css') }}">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="{{ url('css/nice-select.css') }}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ url('css/magnific-popup.css') }}">
    <!-- Bootstrap V4.1.3 Fremwork CSS -->
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <!-- Helper CSS -->
    <link rel="stylesheet" href="{{ url('css/helper.css') }}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ url('css/style.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ url('css/responsive.css') }}">


    @vite(['resources/sass/app.scss', 'resources/js/app.js'])



</head>

<body>
    <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
 <![endif]-->
    <!-- Begin Body Wrapper -->
    <div class="body-wrapper">
        <!-- Begin Header Area -->
        <header>
            <!-- Begin Header Top Area -->
            <div class="header-top">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-3 col-md-4">
                            <div class="header-top-left">
                                <ul class="phone-wrap">
                                    <li><span>For Any Enquiry Call: </span>
                                        <a href="#">(+92) 331 321 1 345</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6 d-lg-block d-none text-center">
                            <h6 class="text-danger font-weight-bold">EStore MultiVendor Ecommerce Plateform </h6>
                        </div>
                        <!-- Begin Header Top Right Area -->
                        <div class="col-lg-3 col-md-8 text-right">
                            <div class="header-top-right">
                                <ul class="ht-menu">
                                    @guest
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                        </li>
                                        @if (Route::has('register'))
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="{{ route('register') }}">{{ __('Register') }}</a>
                                            </li>
                                        @endif
                                    @else
                                        <li class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                {{ Auth::user()->name }}
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                <ul>
                                                    <li><a class="dropdown-item" href="{{ url('user/myaccount') }}">My
                                                            Account</a></li>
                                                    <li><a class="dropdown-item" href="{{ url('user/myorders') }}">My
                                                            Orders & Reviews</a></li>
                                                    <li><a class="dropdown-item" href="{{ url('user/myreviews') }}">My
                                                            Reviews</a></li>
                                                    <li><a class="dropdown-item" href="{{ route('logout') }}"
                                                            onclick="event.preventDefault();
                                                                             document.getElementById('logout-form').submit();">
                                                            {{ __('Logout') }}
                                                        </a>

                                                        <form id="logout-form" action="{{ route('logout') }}"
                                                            method="POST" class="d-none">
                                                            @csrf
                                                        </form>
                                                    </li>
                                                </ul>

                                            </div>
                                        </li>
                                    @endguest

                                    <!-- Begin Setting Area -->
                                </ul>
                            </div>
                        </div>
                        <!-- Header Top Right Area End Here -->
                    </div>
                </div>
            </div>

            <!-- Header Top Area End Here -->


            <div class="header-bottom header-sticky d-none d-lg-block d-xl-block">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Begin Header Bottom Menu Area -->
                            <div class="hb-menu">
                                <nav>
                                    <ul>
                                        <li><a href="{{ url('user/dashboard') }}">Home</a></li>
                                        <li><a href="{{ url('user/category') }}">Category</a></li>
                                        <li><a href="{{ url('user/product') }}">Product</a></li>
                                        <li><a href="{{ url('user/wishlist') }}">Wishlist</a></li>
                                        <li><a href="{{ url('user/aboutus') }}">About Us</a></li>
                                    </ul>

                                </nav>
                            </div>
                            <!-- Header Bottom Menu Area End Here -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header Bottom Area End Here -->
            <!-- Begin Mobile Menu Area -->
            <div class="mobile-menu-area d-lg-none d-xl-none col-12">
                <div class="container">
                    <div class="row">
                        <div class="mobile-menu">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Begin Header Middle Area -->
            <div class="header-middle pl-sm-0 pr-sm-0 pl-xs-0 pr-xs-0">
                <div class="container">
                    <div class="row">
                        <!-- Begin Header Logo Area -->
                        <div class="col-lg-3">
                            <div class="logo pb-sm-30 pb-xs-30">
                                <a href="{{ url('user/dashboard') }}">
                                    <img src="{{ asset('asset/images/icon5.png') }}" width="40%" alt="">
                                </a>
                            </div>
                        </div>
                        <!-- Header Logo Area End Here -->
                        <!-- Begin Header Middle Right Area -->
                        <div class="col-lg-9 pl-0 ml-sm-15 ml-xs-15">
                            <!-- Begin Header Middle Searchbox Area -->
                            <form action="{{ url('user/product') }}" method="post" class="hm-searchbox">
                                @csrf
                                <select id="category-dropdown" name="categoryselect" class=" select-search-category">
                                    <option value="{{ Session::get('Option') }}"></option>
                                </select>
                                <input type="text" name="search" value="{{ Session::get('search') }}"
                                    placeholder="Enter to search product ...">
                                <button class="li-btn" type="submit"><i class="fa fa-search"></i></button>
                            </form>
                            <!-- Header Middle Searchbox Area End Here -->
                            <!-- Begin Header Middle Right Area -->
                            <div class="header-middle-right">
                                <ul class="hm-menu">
                                    <!-- Begin Header Middle Wishlist Area -->
                                    <li class="hm-wishlist">
                                        <a href="{{ url('user/wishlist') }}">
                                            @if (Auth::check())
                                                <span class="cart-item-count wishlist-item-count wishlist-badge"
                                                    id="wishlist-badge">0</span>
                                            @endif
                                            <i class="fa fa-heart text-danger"></i>
                                        </a>
                                    </li>
                                    <!-- Header Middle Wishlist Area End Here -->
                                    <!-- Begin Header Mini Cart Area -->
                                    <li class="hm-minicart">
                                        <a href="{{ url('user/cart') }}" class="hm-minicart-trigger">
                                            <span class="item-icon"></span>
                                            @if (Auth::check())
                                                <span class="item-text">Cart
                                                    <span class="cart-item-count" id="cart-count">0</span>
                                                </span>
                                            @endif
                                        </a>
                                    </li>
                                    <!-- Header Mini Cart Area End Here -->
                                </ul>
                            </div>
                            <!-- Header Middle Right Area End Here -->
                        </div>
                        <!-- Header Middle Right Area End Here -->
                    </div>
                </div>
            </div>
            <!-- Header Middle Area End Here -->
            <!-- Begin Header Bottom Area -->

            <!-- Mobile Menu Area End Here -->
        </header>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-right mb-2">
                        <a href="{{ url('user/category') }}" class="text-primary "><span>See More
                                Categories</span></a>
                    </div>
                    <div id="ajax-container">
                        <div>
                            <div id="li-new-product" class="active show mt-3">
                                <div class="row">
                                    <div class="product-active owl-carousel">

                                        <div class="col-lg-12">
                                            <div class="shadow-md py-3 text-center mb-5 rounded"
                                                style="background: green;">
                                                <div class="product_desc ">
                                                    <h5><a class="text-light" href=""></a></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Header Area End Here -->

        @yield('content')
        <!-- Li's Trendding Products Area End Here -->
        <div class="footer">
            <!-- Begin Footer Static Top Area -->
            <div class="footer-static-top">
                <div class="container">
                    <!-- Begin Footer Shipping Area -->
                    <div class="footer-shipping pt-60 pb-55 pb-xs-25">
                        <div class="row">
                            <!-- Begin Li's Shipping Inner Box Area -->
                            <div class="col-md-6 col-sm-6 pb-xs-30">
                                <div class="li-shipping-inner-box">
                                    <div class="shipping-icon">
                                        <img src="{{ url('images/shipping-icon/3.png') }}" alt="Shipping Icon">
                                    </div>
                                    <div class="shipping-text">
                                        <h2>Shop with Confidence</h2>
                                        <p>you can freely purchase the product without any hesitation</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Li's Shipping Inner Box Area End Here -->
                            <!-- Begin Li's Shipping Inner Box Area -->
                            <div class="col-md-6 col-sm-6 pb-xs-30">
                                <div class="li-shipping-inner-box">
                                    <div class="shipping-icon">
                                        <img src="{{ url('images/shipping-icon/4.png') }}" alt="Shipping Icon">
                                    </div>
                                    <div class="shipping-text">
                                        <h2>24/7 Help Center</h2>
                                        <p>Have a question? Call a Specialist</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Li's Shipping Inner Box Area End Here -->
                        </div>
                    </div>
                    <!-- Footer Shipping Area End Here -->
                </div>
            </div>
            <!-- Footer Static Top Area End Here -->
            <!-- Begin Footer Static Middle Area -->
            <div class="footer-static-middle">
                <div class="container">
                    <div class="footer-logo-wrap pt-50 pb-35">
                        <div class="row text-light">
                            <!-- Begin Footer Logo Area -->
                            <div class="col-lg-6 col-md-6 text-light">
                                <div class="footer-logo">
                                    <img src="{{ asset('asset/images/icon5.png') }}" width="20%"
                                        alt="Footer Logo">
                                    <p class="info">
                                        Our Aim is to provide you everything on door step.
                                    </p>
                                </div>
                                <ul class="des">
                                    <li>
                                        <span>Address: </span>
                                        Nun Wattar walai Road, Tehsil jehngira District Nowshera,
                                        Khyberpakhtonkhowa(KPK), Pakistan
                                    </li>
                                    <li>
                                        <span>Phone: </span>
                                        <a href="#">(+92) 331 321 1 345</a>
                                    </li>
                                    <li>
                                        <span>Email: </span>
                                        <a href="mailto://estore411@gmail.com">estore41122@gmail.com</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Footer Block Area End Here -->
                            <!-- Begin Footer Block Area -->

                            <!-- Footer Block Area End Here -->
                            <!-- Begin Footer Block Area -->
                            <div class="col-lg-6 ">
                                <div class="footer-block">
                                    <h3 class="footer-block-title">Follow Us</h3>
                                    <ul class="social-link">
                                        <li class="twitter">
                                            <a href="https://twitter.com/" data-toggle="tooltip" target="_blank"
                                                title="Twitter">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li class="facebook">
                                            <a href="https://www.facebook.com/" data-toggle="tooltip" target="_blank"
                                                title="Facebook">
                                                <i class="fa fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li class="youtube">
                                            <a href="https://www.youtube.com/" data-toggle="tooltip" target="_blank"
                                                title="Youtube">
                                                <i class="fa fa-youtube"></i>
                                            </a>
                                        </li>
                                        <li class="instagram">
                                            <a href="https://www.instagram.com/" data-toggle="tooltip"
                                                target="_blank" title="Instagram">
                                                <i class="fa fa-instagram"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Footer Newsletter Area End Here -->
                            </div>
                            <!-- Footer Block Area End Here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Static Middle Area End Here -->
        <!-- Begin Footer Static Bottom Area -->
        <!-- Footer Static Bottom Area End Here -->
    </div>


    <!-- Footer Area End Here -->
    </div>

    <!-- Check if flash message exists and show the popup -->
    @if (session()->has('message'))
        <script>
            $(document).ready(function() {
                $('#popup-modal').modal('show');
            });
        </script>
    @endif

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="popup-modal" tabindex="-1" role="dialog" aria-labelledby="popup-modal-label"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popup-modal-label">Popup Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ session('message') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Body Wrapper End Here -->
    <!-- jQuery-V1.12.4 -->
    <script src="{{ url('js/vendor/jquery-1.12.4.min.js') }}"></script>
    <!-- Popper js -->
    <script src="{{ url('js/vendor/popper.min.js') }}"></script>
    <!-- Modernizr js -->
    <script src="{{ url('js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <!-- Bootstrap V4.1.3 Fremwork js -->
    <script src="{{ url('js/bootstrap.min.js') }}"></script>
    <!-- Ajax Mail js -->
    <script src="{{ url('js/ajax-mail.js') }}"></script>
    <!-- Meanmenu js -->
    <script src="{{ url('js/jquery.meanmenu.min.js') }}"></script>
    <!-- Wow.min js -->
    <script src="{{ url('js/wow.min.js') }}"></script>
    <!-- Slick Carousel js -->
    <script src="{{ url('js/slick.min.js') }}"></script>
    <!-- Owl Carousel-2 js -->
    <script src="{{ url('js/owl.carousel.min.js') }}"></script>
    <!-- Magnific popup js -->
    <script src="{{ url('js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Isotope js -->
    <script src="{{ url('js/isotope.pkgd.min.js') }}"></script>
    <!-- Imagesloaded js -->
    <script src="{{ url('js/imagesloaded.pkgd.min.js') }}"></script>
    <!-- Mixitup js -->
    <script src="{{ url('js/jquery.mixitup.min.js') }}"></script>
    <!-- Countdown -->
    <script src="{{ url('js/jquery.countdown.min.js') }}"></script>
    <!-- Counterup -->
    <script src="{{ url('js/jquery.counterup.min.js') }}"></script>
    <!-- Waypoints -->
    <script src="{{ url('js/waypoints.min.js') }}"></script>
    <!-- Barrating -->
    <script src="{{ url('js/jquery.barrating.min.js') }}"></script>
    <!-- Jquery-ui -->
    <script src="{{ url('js/jquery-ui.min.js') }}"></script>
    <!-- Venobox -->
    <script src="{{ url('js/venobox.min.js') }}"></script>
    <!-- Nice Select js -->
    <script src="{{ url('js/jquery.nice-select.min.js') }}"></script>
    <!-- ScrollUp js -->
    <script src="{{ url('js/scrollUp.min.js') }}"></script>
    <!-- Main/Activator js -->
    <script src="{{ url('js/main.js') }}"></script>

    <script>
        //---------------------ajax for display categories in all pages
        function loadCategories() {
            $.ajax({
                url: "{{ url('user/uniquecategory') }}", // Replace with the actual URL to fetch the categories
                method: "GET",
                success: function(response) {
                    var category = response.category;
                    var html = '';

                    // Generate the HTML code for each category
                    for (var i = 0; i < category.length; i++) {
                        var cd = category[i];
                        html += '<div class="item">';
                        html += '<div class="col-lg-12">';
                        html +=
                            '<div class="shadow-md py-3 text-center mb-5 rounded" style="background: green;">';
                        html += '<div class="product_desc">';
                        html += '<h5><a class="text-light" href="/user/category/' + cd.Name + '">' + cd.Name +
                            '</a></h5>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                    }

                    // Update the container element with the generated HTML
                    $("#ajax-container").html('<div class="product-active owl-carousel">' + html + '</div>');

                    // Initialize Owl Carousel
                    $(".product-active").owlCarousel({
                        loop: true,
                        margin: 5,
                        nav: false,
                        dots: true,
                        responsive: {
                            0: {
                                items: 1
                            },
                            600: {
                                items: 3
                            },
                            1000: {
                                items: 5
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error); // Handle any errors that occurred during the AJAX request
                }
            });
        }

        // Call the function to load the categories on page load
        $(document).ready(function() {
            loadCategories();
        });



        // ----------------------- ajax script to add product in wishlist---------------------//
        $('.wishlist-btn').click(function() {
            var productId = $(this).data('product-id');
            var color = $('input[name="color"]:checked').val();
            var size = $('input[name="size"]:checked').val();
            if (typeof size === 'undefined' || size === 'NULL' || size === '') {
                size = '';
            }

            var button = $(this);
            console.log(size);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var url =
                "{{ route('user.addtowishlist', ['id' => ':productId', 'color' => ':color', 'size' => ':size']) }}";
            url = url.replace(':productId', productId).replace(':color', color).replace(':size', size);

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    product_id: productId,
                    color: color,
                    size: size
                },
                success: function(response) {
                    $('#wishlist-badge').text(response.message);

                    if (response.success) {
                        button.addClass('bg-danger text-light');
                    } else {
                        button.removeClass('bg-danger text-light');
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 401) {
                        window.location.href = "{{ route('login') }}";
                    }
                    if (xhr.status === 500) {
                        console.log(error);
                    }
                }
            });
        });








        //------------------------ajax script to remove wishlisted product from wishlist table


        $('.wishlistremove').click(function() {
            var productId = $(this).data('id');
            var color = $(this).data('color');
            var size = $(this).data('size');
            var button = $(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url =
                "{{ route('user.removewishlistproduct', ['id' => ':productId', 'color' => ':color', 'size' => ':size']) }}";
            url = url.replace(':productId', productId).replace(':color', color).replace(':size', size);

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id: productId,
                    color: color,
                    size: size

                },
                success: function(response) {
                    location.reload();
                    // alert(response.message); // Display success message
                    // var wishlistCount = response.wishlistCount;
                    // Add the CSS class for existing products


                },
                error: function(xhr, status, error) {

                    //console.error(error); // Log any error messages
                }
            });
        });



        $(document).ready(function() {
            $('.color-select').change(function() {
                var selectedColor = $(this).val();
                var $sizeSelect = $(this).closest('td').next().find('.size-select');

                // Enable the size select dropdown
                $sizeSelect.prop('disabled', false);

                // Hide all size options and optgroups
                $sizeSelect.find('optgroup').hide();
                $sizeSelect.find('option').hide();

                // Show size options related to the selected color
                $sizeSelect.find('optgroup[data-color="' + selectedColor + '"]').show();
                $sizeSelect.find('optgroup[data-color="' + selectedColor + '"] option').show();

                // Select the first size option
                $sizeSelect.val($sizeSelect.find('optgroup[data-color="' + selectedColor +
                    '"] option:first').val());
            });

            $('.color-select').each(function() {
                var $sizeSelect = $(this).closest('td').next().find('.size-select');

            });
        });




        //------------





        ///=------------------------ajax script to update wishlist badge everytime
        $.ajax({
            url: "{{ route('user.wishlistbadge') }}",
            method: 'get',
            success: function(response) {
                // alert(response.message); // Display success message
                //
                $('#wishlist-badge').text(response.message);

            },
            error: function(xhr, status, error) {
                //console.error(error); // Log any error messages
            }
        });












        //--------------------ajax for toggling radio button for sizes and colors

        $('.color-radio').change(function() {
            var color = $(this).val();
            $('.size-options').hide(); // Hide all size options

            // Show the size options for the selected color
            $('#size-options-' + color).show();
        });









        //--------------ajax function to get value of sizes and colors for product detial page
        $(document).ready(function() {
            // Get the selected color on page reload
            var selectedColor = $('input[name="color"]:checked').val();

            // Show size options for the selected color
            $('#size-options-' + selectedColor).show();

            $('input[name="color"]').change(function() {
                selectedColor = $(this).val();

                // Hide all size options
                $('.size-options').hide();

                // Show size options for the selected color
                $('#size-options-' + selectedColor).show();
            });
        });




        // ----------ajax to show cart badge count
        $(document).ready(function() {
            $('#add-to-cart').on('click', function(e) {
                e.preventDefault();

                var form = $(this).closest('form');
                var url = form.attr('action');
                var formData = form.serialize();
                var addToCartButton = $(this); // Store the button element

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Update the cart badge count
                            $('#cart-count').text(response.cartCount);
                            addToCartButton.addClass(
                            'bg-primary '); // Replace 'bg-success' with the desired CSS class for the new color

                            setTimeout(function() {
                                addToCartButton.removeClass('bg-primary');
                            }, 2000)

                            // Show a success message if needed
                            //alert('Product added to cart.');
                        } else {
                            // Handle the case when adding to cart fails
                            alert('Failed to add product to cart.');
                        }
                    },
                    error: function() {
                        // Handle any error that occurs during the Ajax request
                        window.location.href = "{{ route('login') }}";
                    }
                });
            });
        });




        ///=------------------------ajax script to update cart badge everytime
        $.ajax({
            url: "{{ route('user.cartbadge') }}",
            method: 'get',
            success: function(response) {
                // alert(response.message); // Display success message
                //
                $('#cart-count').text(response.cartCount);

            },
            error: function(xhr, status, error) {
                //console.error(error); // Log any error messages
            }
        });



        //------------Ajax for Getting categories values for Search bar
        $(document).ready(function() {
            // Populate category dropdown on page load
            $.ajax({
                url: '/user/categoryoptionforsearch',
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    if (response.success == true) {
                        var catdata = response.message;
                        var dropdown = $('#category-dropdown');
                        var categories = {};

                        dropdown.empty(); // Clear existing options

                        // Add 'All' option
                        dropdown.append($('<option>').val('0').text('All'));

                        // Add category and subcategory options
                        $.each(catdata, function(index, data) {
                            var categoryId = data.ID;
                            var categoryName = data.categoryname;
                            var subcategoryId = data.Id;
                            var subcategoryName = data.Name;

                            // Add category option if it does not exist
                            if (!categories[categoryId]) {
                                dropdown.append($('<option>').val(categoryId).text(categoryName)
                                    .prop('disabled', true));
                                categories[categoryId] = true;
                            }

                            // Add subcategory option
                            dropdown.append($('<option>').val(subcategoryId).text(' - ' +
                                subcategoryName));
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
    </script>
    @stack('script')
</body>

<!-- index30:23-->

</html>
