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

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 offset-md-3 shadow"
                    style="background: white; padding: 20px; margin-top: 100px; border-radius: 5px">
                    <h2>Configure Google Authenticator</h2>
                    <p style="font-style: italic;">Please do scan the QR Code via Google Authenticator and Verify the code
                    </p>

                    <hr>
                    <form action="{{route('change_password')}}" method="post">
                        @csrf
                        <div style="text-align: center;">

                            <div style="text-align: center;">
                                {!!$QR_Image!!} </div><br><br>

                            <input type="text" class="form-control" name="code" placeholder="******"
                                style="font-size: xx-large;width: 200px;border-radius: 0px;text-align: center;display: inline;color: #0275d8;"><br>
                            <br>
                            <button type="submit" class="btn btn-md btn-primary"
                                style="width: 200px;border-radius: 0px;">Verify</button>

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
