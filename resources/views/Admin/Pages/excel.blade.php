@extends('Admin.master')
@section('title','Excel System - ADMIN')
@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@endsection
@section('content')
    <div class="container-fluid"> @if (Session::has('success'))
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
        <!-- Icon Cards-->
        <div class="row mt-5">
            <div class="col-6">
                <h4>Import Excel File to database</h4>
                <hr>
                <form method="post" action="{{route('lead.import')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-md-3">Select Project</label>
                        <div class="col-md-8">
                            <select id="project" class="form-control d-inline" name="project" >
                                <option disabled selected>Select Project</option>
                                @foreach($projects as $project)
                                    <option value="{{$project->id}}">{{$project->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">Select Excel File</label>
                        <div class="col-md-8">
                            <input type="file" name="uploadfile" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3"></label>
                        <div class="col-md-8">
                            <input type="submit" value="Upload" name="import-excel" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
