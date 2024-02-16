<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ url('favicon.ico') }}" type="image/x-icon">
    <title>EStore multi vendor Ecommerce plateform</title>
    <!-- Custom CSS -->
    <link href="{{ asset('asset/libs/flot/css/float-chart.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/extra-libs/multicheck/multicheck.css') }}">
    <link href="{{ asset('asset/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!--vite(['resources/sass/app.scss', 'resources/js/app.js'])-->
    <!--bootstrap Icon Linkage---->
    <link rel="stylesheet"
        href="{{ url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css') }}">
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <!----------top navigation bar---------------->
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="{{ url('/seller/dashboard') }}">
                        <!-- Logo icon -->
                        <b class="logo-icon ">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{ asset('asset/images/icon7.png') }}" alt="homepage"
                                class="light-logo img-fluid" />

                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <h1 class="pt-4 text-danger">EStore</h1>

                        </span>
                        <!-- Logo icon -->
                        <!-- <b class="logo-icon"> -->
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <!-- <img src="assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

                        <!-- </b> -->
                        <!--End Logo icon -->
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a
                                class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>

                    </ul>
                    <ul></ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                       <!-- <li class="nav-item dropdown" id="notify">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-bell font-24"></i>
                            </a>
                            <div class="dropdown-menu d-none" id="notify" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>-->

                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-light waves-effect waves-dark pro-pic"
                                href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"> {{ Auth::user()->name }}<i
                                    class=" fas fa-chevron-down m-r-5 m-l-5"></i></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <a class="dropdown-item" href="{{ url('seller/changepassword') }}"><i
                                        class="fas fa-key m-r-5 m-l-5"></i> Change Password</a>
                                <div class="dropdown-divider"></div>
                                <!--  <a class="dropdown-item" href="url('/seller/logout')}}"> Logout</a>-->
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                      document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off m-r-5 m-l-5"></i>
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- =========================================================================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->


        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar ">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ url('/seller/dashboard') }}" aria-expanded="false"><i
                                    class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ url('/seller/product') }}" aria-expanded="false"><i
                                    class="bi bi-basket2-fill"></i><span class="hide-menu">Manage Product</span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)" aria-expanded="false"><i class=" fas fa-industry"></i><span
                                    class="hide-menu">Manage Stock</span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="{{ url('/seller/addstock') }}"
                                        class="sidebar-link"><i class=" fas fa-plus-circle"></i><span
                                            class="hide-menu">Add Stock</span></a></li>
                                <!--<li class="sidebar-item"><a href="{ url('/seller/stock') }}"
                                        class="sidebar-link"><i class=" fas fa-clipboard-list"></i><span
                                            class="hide-menu">Low Stock</span></a></li>-->
                            </ul>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ url('/seller/order') }}" aria-expanded="false"><i
                                    class="bi bi-life-preserver"></i><span class="hide-menu">Orders</span></a></li>
                        <!-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{ url('/seller/returnorder') }}" aria-expanded="false"><i
                                    class="fas fa-undo"></i><span class="hide-menu">Return Order</span></a></li>-->
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ url('/seller/review') }}" aria-expanded="false"><i
                                    class="bi bi-chat-left-text-fill"></i><span class="hide-menu">Reviews</span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ url('/seller/supplier') }}" aria-expanded="false"><i
                                    class="fas fa-truck-loading"></i><span class="hide-menu"> Suppliers</span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ url('/seller/complaint') }}" aria-expanded="false"><i
                                    class="bi bi-clipboard-x"></i><span class="hide-menu">Complaints</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ url('/seller/stocksummary') }}" aria-expanded="false"><i
                                    class="fas fa-history"></i><span class="hide-menu">Stock Summary</span></a></li>

                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ url('/seller/setting') }}" aria-expanded="false"><i
                                    class="bi bi-gear-fill"></i><span class="hide-menu">Settings</span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            @yield('content')





            <!-- ============================================================== -->



            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                All Rights Reserved by &copy; EStore Multi-Vendor Ecommerce Plateform.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>

    <script src="{{ asset('asset/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('asset/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('asset/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('asset/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>
    <!--This page JavaScript -->
    <!-- <script src="dist/js/pages/dashboards/dashboard1.js"></script> -->
    <!-- Charts js Files -->
    <script src="{{ asset('asset/libs/flot/excanvas.js') }}"></script>
    <script src="{{ asset('asset/libs/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('asset/libs/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('asset/libs/flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('asset/libs/flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('asset/libs/flot/jquery.flot.crosshair.js') }}"></script>
    <script src="{{ asset('asset/libs/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/chart/chart-page-init.js') }}"></script>
    <script src="{{ url('https://code.jquery.com/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ url('https://cdn.jsdelivr.net/npm/chart.js') }}"></script>
    <script src="{{ url('https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js') }}"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="{{ url('https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js') }}"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <script src="{{ asset('asset/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
    <script src="{{ asset('asset/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
    <script src="{{ asset('asset/extra-libs/DataTables/datatables.min.js') }}"></script>



    <!-------edit category model script for editing and sending value to model--------->
    <script>
        /*
                const checkbox = document.getElementById('variation');

                const box = document.getElementById('var');

                checkbox.addEventListener('click', function handleClick() {
                    if (checkbox.checked) {
                        box.style.display = 'block';
                    } else {
                        box.style.display = 'none';
                    }
                });

        $(document).ready(function() {
                    var i = 1;


                    $('#add').click(function() {
                        i++;
                        $('#var').append('<div id="row' + i +
                            '" class="row"><div class="col-4"><div class="form-group"><label for="size">Product Size</label><input type="text" class="form-control" id="size" name="size[]" placeholder="Enter Product size"></div></div><div class="col-4"><div class="form-group"><label for="color">Product Color</label><input type="text" class="form-control" id="color" name="color[]" placeholder="Enter Product color"></div></div><div class="col-4"><div class="form-group"><label for="variquantity">Product Quantity</label><input type="text" class="form-control" id="variquantity" name="variquantity[]" placeholder="Enter Product Quantity"><div class="invalid-feedback">Product Quantity Cant Be Empty</div></div><button type="button" name="remove" id="' +i+'" class="btn btn-danger btn_remove">X</button></div></div>');
                    });


                    $(document).on('click', '.btn_remove', function() {
                        var button_id = $(this).attr("id");
                        $('#row' + button_id + '').remove();
                    });
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                });

                 //       $('#zero_config').DataTable();

           //     $('#changepassword').appendTo("body");
                */
        $('#editmodel').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var cid = button.data('catid')
            var cname = button.data('catname')
            var cdesc = button.data('catdesc')
            var modal = $(this)
            // modal.find('.modal-title').text('New message to ' + recipient)

            modal.find('.modal-body input').val(cname)
            modal.find('.modal-body textarea').val(cdesc)
            modal.find('.modal-body #catid').val(cid)


        });


        $('#editsuppliermodel').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id')
            var name = button.data('name')
            var mob = button.data('mobileno')
            var address = button.data('address')
            var modal = $(this)
            // modal.find('.modal-title').text('New message to ' + recipient)

            modal.find('.modal-body #id').val(id)
            modal.find('.modal-body #name').val(name)
            modal.find('.modal-body #mobileno').val(mob)
            modal.find('.modal-body #address').val(address)


        });




        $('#demoModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var cid = button.data('catid')
            var modal = $(this)


            modal.find('.modal-body input').val(cid)


        });
    </script>

    <script>
        $('#demoModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var cid = button.data('catid')
            var modal = $(this)


            modal.find('.modal-body input').val(cid)


        });
    </script>

    <script type="text/javascript">
        $(function() {

            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ Route('seller.list') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#notify').click(function(e) {
                e.preventDefault();
                $('.dropdown-menu').toggle();
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.nav-link.dropdown-toggle').click(function(e) {
                e.preventDefault();
                $('.dropdown-menu').toggle();
                if ($('.dropdown-menu').is(':visible')) {
                    // Make AJAX request to fetch seller notifications
                    $.ajax({
                        url: '{{ route('seller.notifications') }}',
                        method: 'GET',
                        type: 'json',
                        success: function(response) {
                            // Handle the response
                            displayNotifications(response);
                        },
                        error: function(xhr, status, error) {
                            // Handle the error
                            console.error(error);
                        }
                    });
                }
            });

            // Function to display notifications
            function displayNotifications(notifications) {
                var notificationContainer = $('#notify');

                // Clear existing notifications
                notificationContainer.empty();

                // Iterate over notifications and append to the container
                notifications.forEach(function(notification) {
                    var message = notification.data.message;
                    var notificationElement = $('<a class="dropdown-item" href="#">' + message + '</a>');
                    notificationContainer.append(notificationElement);
                });
            }
        });
    </script>

    @stack('scripts')

</body>

</html>
