@extends('Admin.master')
@section('title','Projects System - ADMIN')
@section('content')
    <div class="container-fluid">
        <!-- DataTables Projects -->
        <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-4 float-left">
                        <i class="fas fa-fw fa-users"></i>
                        Projects List
                    </div>
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4 float-right">
                        <button type="button" class="btn btn-success btn-sm float-right" href="#" data-toggle="modal"
                            data-target="#createProject">Add Project <i class="fas fa-fw fa-user-plus"></i></button>
                    </div>
                </div>
            </div>
            <!-- Create Project -->
            <!-- Large modal -->
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


            @foreach ($errors->get('projectname') as $message)
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
            @foreach ($errors->get('projectred') as $message)
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
            <div class="modal fade bd-example-modal-lg" id="createProject" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create New Project</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{route('admin.project.store')}}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <input style="margin-bottom: 15px;" type="text" id="projectname" class="form-control"
                                        name="projectname" placeholder="Project Name" required>
                                        @foreach ($errors->get('projectname') as $message)
                                        <span class="error">
                                            {{ $message }}*
                                        </span>
                                       @endforeach
                                    <input style="margin-bottom: 15px;" type="text" id="projectred" class="form-control"
                                        name="projectred" placeholder="Project Developer" required>
                                        @foreach ($errors->get('projectred') as $message)
                                        <span class="error">
                                            {{ $message }}*
                                        </span>
                                       @endforeach
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <input class="btn btn-success" type="submit" name="submit" value="Confirm" />
                            </div>
                        </form>
                    </div>
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
                                <th>Project Name</th>
                                {{-- <th>Responsible Agent</th> --}}
                                <th>Real Estate Developer</th>

                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($projects as $project)
                            <tr>
                                <td>{!!$loop->iteration!!}</td>
                                <td>{!! $project->name !!}</td>
                                {{-- <td>{!!$project->agent ? $project->agent->fullName : 'Not Selected yet'!!}</td> --}}
                                <td>{!!$project->developerName!!}</td>
                                <td style="display: flex">
                                    <form action='{{route('admin.project.destroy',[$project])}}' method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button style="margin-bottom: 5px;" onclick="return confirm('Are you ready want to delete this project ?')" name="delete" value="1"
                                            class="btn btn-danger btn-sm"><i class="fas fa-fw fa-user-minus"></i></button>

                                    </form>
                                    <button style="margin-bottom: 5px; margin-left:5px" id="edit" data-role="edit" data-toggle="modal"
                                        data-target="#editProject-{!!$project->id!!}" value="1" class="btn btn-info btn-sm">
                                        <i class="fas fa-fw fa-user-edit"></i>
                                    </button>
                                </td>
                                <!-- Edit Project Modal -->

                                <div class="modal fade bd-example-modal-lg" id="editProject-{!!$project->id!!}" tabindex="-1" role="dialog"
                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="edit-label-">Edit Project</h5>
                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form id="form-edit-1" action="{{route('admin.project.update',[$project])}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" id="1" />
                                                <div class="modal-body">
                                                    <div class="col-md-12">
                                                        <input style="margin-bottom: 15px;" type="text" id="projectname-{!!$project->id!!}"
                                                            class="form-control" name="projectname"
                                                            placeholder="Project Name" value="{!!$project->name!!}" required>
                                                            @foreach ($errors->get('projectname') as $message)
                                                            <span class="error">
                                                                {{ $message }}*
                                                            </span>
                                                           @endforeach
                                                        <input style="margin-bottom: 15px;" type="text" id="projectred{!!$project->id!!}"
                                                            class="form-control" name="projectred"
                                                            placeholder="Real Estate Developer" value="{!!$project->developerName!!}" required>
                                                            @foreach ($errors->get('projectred') as $message)
                                                            <span class="error">
                                                                {{ $message }}*
                                                            </span>
                                                           @endforeach
                                                        {{-- <select style="margin-bottom: 15px;" class="form-control"
                                                            name="projectseller">
                                                            <option value="{!!$project->agent ? $project->agent->id : '' !!}" selected>{!!$project->agent ? $project->agent->name : ''!!}</option>
                                                            @foreach ($agents as $agent)
                                                            <option value="{!!$agent->id!!}">{!!$agent->fullName!!}</option>
                                                            @endforeach
                                                        </select> --}}

                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button class="btn btn-success" type="submit" name="update"
                                                        id="update-1" value="1">Confirm</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                                @endforeach
                                <!-- End Edit lead Modal -->
                            <!-- Edit Project Modal -->

                            </form>
                </div>
            </div>
        </div>
        <!-- End Edit lead Modal -->
        </tr>
        </tbody>
        </table>
    </div>
    </div>
    </div>

    <p class="small text-center text-muted my-5">
        <em>**********</em>
    </p>

    </div>
    <!-- /.container-fluid -->
@endsection
@section('script')
      <!-- Core plugin JavaScript-->
  <script src="{{asset('js/jquery.easing.min.js')}}"></script>
    <!-- Demo scripts for this page-->
    <script src="{{asset('js/demo/datatables-demo.js')}}"></script>
@endsection
