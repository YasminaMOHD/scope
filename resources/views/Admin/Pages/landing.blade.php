@extends('Admin.master')
@section('title','Landing System - ADMIN')
@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Custom styles for this template-->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Icon Cards-->
        <div class="row mt-5">
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


            @foreach ($errors->get('project') as $message)
            <script>
                $(function () { //ready
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "showDuration": "1000",
                    }
                    toastr.error("{!! $message !!}");
                });
                </script>
            @endforeach
            @foreach ($errors->get('page') as $message)
            <script>
                $(function () { //ready
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "showDuration": "1000",
                    }
                    toastr.error("{!! $message !!}");
                });
                </script>
            @endforeach
            <div class="col-6">
                <h4>Add Lading Page</h4>
                <hr>
                <form method="post" action="{{route('admin.landing.store')}}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-md-3">Select Project</label>
                        <div class="col-md-8">
                            <select id="project" class="form-control d-inline" name="project" required>
                                <option disabled selected>Select Project</option>
                                @foreach ($projects as $project )
                                <option value="{!!$project ? $project->id : ''!!}" name="project">{!!$project ? $project->name : "" !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">Page URL</label>
                        <div class="col-md-8">
                            <input id="page" class="form-control d-inline" name="page" placeholder="Page URL here" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3"></label>
                        <div class="col-md-8">
                            <input type="submit" value="Add Page" name="add-page" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- DataTables Projects -->
        <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                </div>
            </div>
            <!-- Edit Project -->
            <!-- Large modal -->


            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#id</th>
                                <th>Page URL</th>
                                <th>Project</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($landing as $land )
                                <tr>
                                    <td>{!!$loop->iteration!!}</td>
                                    <td><a href="{!!$land->url!!}">{!!$land->url!!}</a></td>
                                    <td>{!!$land->project ? $land->project->name : '' !!}</td>
                                    <td>
                                        <ul style="
                                        list-style-type: none;
                                        text-align: center;
                                        margin: 0;
                                        padding: 0;
                                  ">
                                   <li
                                       style="display: inline-block;margin-right: 10px; margin-bottom: 5px">
                                       <button id="edit" data-role="edit" data-toggle="modal"
                                           data-target="#editPage-{!!$land->id!!}" value="{!!$land->id!!}"
                                           class="btn btn-secondary btn-sm">
                                           <i class="fas fa-fw fa-user-edit"></i>
                                       </button>
                                   </li>
                                   <li
                                                        style="display: inline-block; margin-right: 10px;  margin-bottom: 5px">
                                                        <form action="{{route('admin.landing.destroy',$land->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button style="width: 36px;" type="submit"
                                                        class="btn btn-danger btn-sm" onclick="return confirm('Are you want to delete Project URL Page ?')"  ><i
                                                            class="fas fa-fw fa-user-minus" ></i></button>
                                                    </form>
                                                    </li>
                                        </ul>
                                    <div class="modal fade bd-example-modal-lg" id="editPage-{!!$land->id!!}" tabindex="-1" role="dialog"
                                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Project Page URL</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('admin.landing.update',[$land->id])}}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="col-md-12">
                                                            <select id="project" class="form-control d-inline" name="project" required>
                                                                <option value="{!!$land->project ? $land->project->id : '' !!}" selected>{!!$land->project ? $land->project->name : ''!!}</option>
                                                                @foreach ($projects as $project )
                                                                <option value="{!!$project ? $project->id : '' !!}" name="project">{!!$project ? $project->name : ''!!}</option>
                                                                @endforeach
                                                            </select>

                                                            <input style="margin-bottom: 15px;" type="text" id="projectrededit"
                                                                class="form-control mt-3" name="page" placeholder="URL" value="{!!$land->url!!}"
                                                                required>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                        <input class="btn btn-success" type="submit" name="edit" value="Confirm" />
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
