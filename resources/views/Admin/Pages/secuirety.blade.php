@extends('Admin.master')
@section('title','Security System - ADMIN')
@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Custom styles for this template-->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endsection
@section('content')
    <div class="container-fluid">
        @if (Session::has('success'))
        <script>
            $(function () { //ready
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "showDuration": "1000",
                }
                toastr.success("{!! Session::get('success') !!}");
            });
      </script>
        @endif
        @if (Session::has('error'))
        <script>
            $(function () { //ready
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "showDuration": "1000",
                }
                toastr.error("{!! Session::get('error') !!}");
            });
      </script>
        @endif
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 offset-md-3 shadow"
                    style="background: white; padding: 20px; margin-top: 100px; border-radius: 5px">
                    <h2>Change Master Admin Password</h2>
                    <hr class="mb-3">
                    <form action="{{route('updatepassword')}}" method="post">
                        @csrf
                        <input style="margin-bottom: 15px;" type="password" id="c_password" class="form-control"
                            name="c_password" placeholder="Current Password" required>
                        <input style="margin-bottom: 15px;" type="password" id="n_password" class="form-control"
                            name="n_password" placeholder="New Password" required>
                        <div style="text-align: center;">
                            <input type="submit" name="changep" class="btn btn-md btn-danger"
                                style="width: 200px;border-radius: 0px;" value="Change Password" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <p class="small text-center text-muted my-5">
        <em>**********</em>
    </p>
    </div>
@endsection
@section('script')
      <!-- Core plugin JavaScript-->
  <script src="{{asset('js/jquery.easing.min.js')}}"></script>
    <!-- Demo scripts for this page-->
    <script src="{{asset('js/demo/datatables-demo.js')}}"></script>

    <!-- Page level plugin JavaScript-->
    <script src="{{asset('js/chart.js/Chart.min.js')}}"></script>

    <!-- Demo scripts for this page-->
    <script src="{{asset('js/demo/chart-area-demo.js')}}"></script>
@endsection
