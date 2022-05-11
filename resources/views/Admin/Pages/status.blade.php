@extends('Admin.master')
@section('title', 'status System - Super Admin')
@section('content')
    <div class="container-fluid">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-4 float-left">
                    <i class="fas fa-fw fa-users"></i>
                    Status List
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-4 float-right">
                    <button type="button" class="btn btn-success btn-sm float-right" href="#" data-toggle="modal"
                        data-target="#createstatus">Add Status <i class="fas fa-fw fa-user-plus"></i></button>
                </div>
            </div>
        </div>
        <!-- Create status -->
        <!-- Large modal -->
        @if (Session::has('success'))
            <script>
                $(function() { //ready
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "showDuration": "1000",
                    }
                    toastr.success("{!! Session::get('success') !!}");
                });
            </script>
        @endif


        @foreach ($errors->get('name') as $message)
            <script>
                $(function() { //ready
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "showDuration": "1000",
                    }
                    toastr.error("{!! $message !!}");
                });
            </script>
        @endforeach
        @foreach ($errors->get('permission') as $message)
            <script>
                $(function() { //ready
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "showDuration": "1000",
                    }
                    toastr.error("{!! $message !!}");
                });
            </script>
        @endforeach
        <div class="modal fade bd-example-modal-lg" id="createstatus" tabindex="-1" status="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create New Status</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('superAdmin.status.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="col-md-12">
                                <input type="text" name="name" class="form-control" placeholder="Status Name" required>
                                @foreach ($errors->get('name') as $message)
                                <span class="error">
                                    {{ $message }}*
                                </span>
                               @endforeach
                                <p class="mt-3 ml-2">Choose Color For Status:</p>
                                <input type="color" name="color" class="form-control color" id="color" value="#fff" required>
                                <div class="icon-primary-color">
                                    <div class="mt-2">
                                        <div class="row">
                                                <div class="col-sm-1 col-2" style="display: flex">
                                                    <input type="radio"  name="colorradio" value='#d9d9d9' class="mr-1">
                                                    <span style="width: 15px;height:15px;border-radius: 50%;background: #d9d9d9 !important; display: inline-block"></span>
                                                </div>
                                                <div class="col-sm-1 col-2" style="display: flex">
                                                    <input type="radio"  name="colorradio" value='#007bff' class="mr-1">
                                                    <span style="width: 15px;height:15px;border-radius: 50%;background: #007bff  !important;display: inline-block"></span>
                                                </div>
                                                <div class="col-sm-1 col-2" style="display: flex">
                                                    <input type="radio"  name="colorradio" value='#6c757d' class="mr-1">
                                                    <span style="width: 15px;height:15px;border-radius: 50%;background: #6c757d  !important;display: inline-block"></span>
                                                </div>
                                                <div class="col-sm-1 col-2" style="display: flex">
                                                    <input type="radio"  name="colorradio" value='#dc3545' class="mr-1">
                                                    <span style="width: 15px;height:15px;border-radius: 50%;background: #dc3545 !important;display: inline-block"></span>
                                                </div>
                                                <div class="col-sm-1 col-2" style="display: flex">
                                                    <input type="radio"  name="colorradio" value='#ffc107' class="mr-1">
                                                    <span style="width: 15px;height:15px;border-radius: 50%;background: #ffc107 !important;display: inline-block"></span>
                                                </div>
                                                <div class="col-sm-1 col-2" style="display: flex">
                                                    <input type="radio"  name="colorradio" value='#28a745' class="mr-1">
                                                    <span style="width: 15px;height:15px;border-radius: 50%;background: #28a745 !important;display: inline-block"></span>
                                                </div>
                                                <div class="col-sm-1 col-2" style="display: flex">
                                                    <input type="radio"  name="colorradio" value='#17a2b8' class="mr-1">
                                                    <span style="width: 15px;height:15px;border-radius: 50%;background: #17a2b8 !important;display: inline-block"></span>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($errors->get('color') as $message)
                                <span class="error">
                                    {{ $message }}*
                                </span>
                               @endforeach
                                <p class="mt-3 ml-2">Choose icon For Status:</p>
                                <div class="icon-status mt-3">
                                    <div class="icon-state row">
                                      <div class="col-sm-2 col-1">
                                        <input type="radio" id="icon1" name="icon" value='<i class="fas fa-people-arrows"></i>'>
                                        <label for="icon1"> <i class="fas fa-people-arrows"></i></label>
                                    </div>
                                      <div class="col-sm-2 col-1">
                                        <input type="radio" id="icon2" name="icon" value='<i class="fas fa-phone-slash"></i>'>
                                        <label for="icon2"><i class="fas fa-phone-slash"></i></label>
                                    </div>
                                      <div class="col-sm-2 col-1">
                                        <input type="radio" id="icon3" name="icon" value='<i class="fas fa-exclamation-circle"></i>'>
                                        <label for="icon3"><i class="fas fa-exclamation-circle"></i></label>
                                    </div>
                                      <div class="col-sm-2 col-1">
                                        <input type="radio" id="icon4" name="icon" value='<i class="far fa-snowflake"></i>'>
                                        <label for="icon4"><i class="far fa-snowflake"></i></label>
                                    </div>
                                      <div class="col-sm-2 col-1">
                                        <input type="radio" id="icon5" name="icon" value='<i class="fas fa-fw fa-list"></i>'>
                                        <label for="icon5"><i class="fas fa-fw fa-list"></i></label>
                                    </div>
                                      <div class="col-sm-2 col-1">
                                        <input type="radio" id="icon6" name="icon" value='<i class="fas fa-fire-alt"></i>'>
                                        <label for="icon6"><i class="fas fa-fire-alt"></i></label>
                                    </div>
                                      <div class="col-sm-2 col-1">
                                        <input type="radio" id="icon7" name="icon" value='<i class="fas fa-hands-helping"></i>'>
                                        <label for="icon7"><i class="fas fa-hands-helping"></i></label>
                                    </div>
                                    @foreach ($errors->get('icon') as $message)
                                    <span class="error">
                                        {{ $message }}*
                                    </span>
                                   @endforeach
                                    </div>
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


  <!-- DataTables statuss -->
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>#id</th>
                    <th>Status Name</th>
                    <th>Color</th>
                    <th>Icone</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($statuses as $status)
                <tr>
                    <td>{!!$loop->iteration!!}</td>
                    <td>{!! $status->name !!}</td>
                    <td>{!! $status->color !!}</td>
                    <td>{!! $status->icon !!}</td>
                    <td style="display: flex">
                        <form action='{{route('superAdmin.status.destroy',[$status])}}' method="post">
                            @csrf
                            @method('DELETE')
                            <button style="margin-bottom: 5px;" onclick="confirm('Are you ready want to delete this status ?')" name="delete" value="1"
                                class="btn btn-danger btn-sm"><i class="fas fa-fw fa-user-minus"></i></button>

                        </form>
                        <button style="margin-bottom: 5px; margin-left:5px" id="edit" data-status="edit" data-toggle="modal"
                            data-target="#editstatus-{!!$status->id!!}" value="1" class="btn btn-info btn-sm">
                            <i class="fas fa-fw fa-user-edit"></i>
                        </button>
                    </td>
                    <!-- Edit status Modal -->

                    <div class="modal fade bd-example-modal-lg" id="editstatus-{!!$status->id!!}" tabindex="-1" status="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="edit-label-">Edit status</h5>
                                    <button class="close" type="button" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form id="form-edit-1" action="{{route('superAdmin.status.update',[$status])}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="col-md-12">
                                            <input type="text" name="name" class="form-control" placeholder="Status Name" value="{!!$status->name!!}">
                                            <p class="mt-3 ml-2">Choose Color For Status:</p>
                                            <input type="color" name="color" class="form-control color" value="{!!$status->color!!}" value="{!!$status->color!!}">
                                            <div class="icon-primary-color">
                                                <div class="mt-2">
                                                    <div class="row">
                                                            <div class="col-sm-1 col-2" style="display: flex">
                                                                <input type="radio"  name="colorradio" value='#d9d9d9' class="mr-1">
                                                                <span style="width: 15px;height:15px;border-radius: 50%;background: #d9d9d9 !important; display: inline-block"></span>
                                                            </div>
                                                            <div class="col-sm-1 col-2" style="display: flex">
                                                                <input type="radio"  name="colorradio" value='#007bff' class="mr-1">
                                                                <span style="width: 15px;height:15px;border-radius: 50%;background: #007bff  !important;display: inline-block"></span>
                                                            </div>
                                                            <div class="col-sm-1 col-2" style="display: flex">
                                                                <input type="radio"  name="colorradio" value='#6c757d' class="mr-1">
                                                                <span style="width: 15px;height:15px;border-radius: 50%;background: #6c757d  !important;display: inline-block"></span>
                                                            </div>
                                                            <div class="col-sm-1 col-2" style="display: flex">
                                                                <input type="radio"  name="colorradio" value='#dc3545' class="mr-1">
                                                                <span style="width: 15px;height:15px;border-radius: 50%;background: #dc3545 !important;display: inline-block"></span>
                                                            </div>
                                                            <div class="col-sm-1 col-2" style="display: flex">
                                                                <input type="radio"  name="colorradio" value='#ffc107' class="mr-1">
                                                                <span style="width: 15px;height:15px;border-radius: 50%;background: #ffc107 !important;display: inline-block"></span>
                                                            </div>
                                                            <div class="col-sm-1 col-2" style="display: flex">
                                                                <input type="radio"  name="colorradio" value='#28a745' class="mr-1">
                                                                <span style="width: 15px;height:15px;border-radius: 50%;background: #28a745 !important;display: inline-block"></span>
                                                            </div>
                                                            <div class="col-sm-1 col-2" style="display: flex">
                                                                <input type="radio"  name="colorradio" value='#17a2b8' class="mr-1">
                                                                <span style="width: 15px;height:15px;border-radius: 50%;background: #17a2b8 !important;display: inline-block"></span>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 ml-2">Choose icon For Status:</p>
                                            <div class="icon-status mt-3">
                                                <div class="icon-state row">
                                                  <div class="col-sm-2 col-1">
                                                    <input type="radio" id="icon1" name="icon" value='<i class="fas fa-people-arrows"></i>'
                                                    @if ($status->icon == '<i class="fas fa-people-arrows"></i>')
                                                      checked
                                                    @endif >
                                                    <label for="icon1"> <i class="fas fa-people-arrows"></i></label>
                                                </div>
                                                  <div class="col-sm-2 col-1">
                                                    <input type="radio" id="icon2" name="icon" value='<i class="fas fa-phone-slash"></i>'
                                                    @if ($status->icon == '<i class="fas fa-phone-slash"></i>')
                                                      checked
                                                    @endif>
                                                    <label for="icon2"><i class="fas fa-phone-slash"></i></label>
                                                </div>
                                                  <div class="col-sm-2 col-1">
                                                    <input type="radio" id="icon3" name="icon" value='<i class="fas fa-exclamation-circle"></i>'
                                                    @if ($status->icon == '<i class="fas fa-exclamation-circle"></i>')
                                                    checked
                                                  @endif>
                                                    <label for="icon3"><i class="fas fa-exclamation-circle"></i></label>
                                                </div>
                                                  <div class="col-sm-2 col-1">
                                                    <input type="radio" id="icon4" name="icon" value='<i class="far fa-snowflake"></i>'
                                                    @if ($status->icon == '<i class="far fa-snowflake"></i>')
                                                    checked
                                                  @endif>
                                                    <label for="icon4"><i class="far fa-snowflake"></i></label>
                                                </div>
                                                  <div class="col-sm-2 col-1">
                                                    <input type="radio" id="icon5" name="icon" value='<i class="fas fa-fw fa-list"></i>'
                                                    @if ($status->icon == '<i class="fas fa-fw fa-list"></i>')
                                                    checked
                                                  @endif>
                                                    <label for="icon5"><i class="fas fa-fw fa-list"></i></label>
                                                </div>
                                                  <div class="col-sm-2 col-1">
                                                    <input type="radio" id="icon6" name="icon" value='<i class="fas fa-fire-alt"></i>'
                                                    @if ($status->icon == '<i class="fas fa-fire-alt"></i>')
                                                    checked
                                                  @endif>
                                                    <label for="icon6"><i class="fas fa-fire-alt"></i></label>
                                                </div>
                                                  <div class="col-sm-2 col-1">
                                                    <input type="radio" id="icon7" name="icon" value='<i class="fas fa-hands-helping"></i>'
                                                    @if ($status->icon == '<i class="fas fa-hands-helping"></i>')
                                                    checked
                                                  @endif>
                                                    <label for="icon7"><i class="fas fa-hands-helping"></i></label>
                                                </div>
                                                </div>
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
                <!-- Edit status Modal -->

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
    <script>
        $(document).ready(function(){
            function myfunction(color){
                $('.color').val(color);
            }
            document.querySelectorAll("input[name='colorradio']").forEach(function(el){
                el.addEventListener("click", function(){
                    console.log(el.value);
                    myfunction(el.value);
                });
    });
        });
    </script>
@endsection

