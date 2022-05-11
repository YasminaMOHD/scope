<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>
    <link rel="icon" href="{{asset('image/logo.png')}}">
    <link href="{{asset('css/all.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="{{asset('css/dataTables.bootstrap4.css')}}" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
    <link rel="stylesheet" type="text/css"
     href="{{asset('toastr/toastr.min.css')}}">


    <!-- Custom fonts for this template-->
    @yield('style')

</head>

<body id="page-top">
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
        <a class="navbar-brand mr-1" href="dashboard.php"><img src="{{asset('image/logo.png')}}" width="80"></a>
        <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>

        <ul class="navbar-nav ml-auto ml-md-0">
            <style>
                .scrollable-menu {
                    height: auto;
                    max-height: 700px;
                    overflow-x: hidden;
                }

                ::-webkit-scrollbar {
                    width: 5px;
                    z-index: -1;
                }

                /* Track */
                ::-webkit-scrollbar-track {
                    background: #f1f1f1;
                    border-radius: 5px;
                }

                /* Handle */
                ::-webkit-scrollbar-thumb {
                    background: #888;
                    border-radius: 5px;
                }

                /* Handle on hover */
                ::-webkit-scrollbar-thumb:hover {
                    background: #555;
                }

                .dropdown-menu {
                    /*overflow: hidden;*/
                }

                ::-webkit-scrollbar {}

                @media only screen and (min-width: 767px) {
                    #sidebarToggle {
                        display: none;
                    }
                }

            </style>
            <li class="nav-item no-arrow" style="position: absolute !important; float: right; right: 45px; top: 12px;">
                <span style="color: #ffffff; display: inline-block;">{!! Auth::user()->name !!}</span>


                <a class="nav-link" style="display: inline-block;" href="#" role="button" data-toggle="modal"
                    data-target="#logoutModal" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-power-off"></i>
                </a>
            </li>
        </ul>

    </nav>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger">Logout</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    <div id="wrapper">

        <!-- Sidebar -->
        @include('Admin.includes.SideMenu')

        <div id="content-wrapper">
            @yield('content')

            <!-- Sticky Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright © ScopeRealEstate 2022</span>
                    </div>
                </div>
            </footer>

        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>


    <script src="{{asset('js/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('js/datatables/dataTables.bootstrap4.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('js/sb-admin.min.js')}}"></script>

    @yield('script')
    <script src="{{asset('toastr/toastr.min.js')}}"></script>

</body>

</html>
