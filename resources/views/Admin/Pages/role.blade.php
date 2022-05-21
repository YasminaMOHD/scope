@extends('Admin.master')
@section('title','Role System - Super Admin')
@section('style')
    link href="{{asset('css/icheck-bootstrap.min.css')}}" rel="stylesheet" type="text/css"
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-4 float-left">
                    <i class="fas fa-fw fa-users"></i>
                    Role List
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-4 float-right">
                    <button type="button" class="btn btn-success btn-sm float-right" href="#" data-toggle="modal"
                        data-target="#createrole">Add Role <i class="fas fa-fw fa-user-plus"></i></button>
                </div>
            </div>
        </div>
        <!-- Create role -->
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


        @foreach ($errors->get('name') as $message)
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
        @foreach ($errors->get('permission') as $message)
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
        <div class="modal fade bd-example-modal-lg" id="createrole" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create New role</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{route('superAdmin.role.store')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="col-md-12">
                                <select name="name" id="name" class="form-control">
                                    <option value="admin"class="p-2" >Admin</option>
                                    <option value="user" class="p-2" selected>User</option>
                                </select> <br>
                                @foreach ($errors->get('name') as $message)
                                <span class="error">
                                    {{ $message }}*
                                </span>
                               @endforeach
                                    <p>Choose Permission For Rule:</p>
                                     <div class="row">
                                         <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input icheck-primary checkjs" type="checkbox" id="select-all"
                                                      >
                                                <label class="form-check-label">
                                                     check All
                                                </label>
                                              </div>
                                         </div>
                                         @foreach (config('Permission') as $r )
                                           <div class="col-md-4 col-sm-6 col-12">
                                                  <div class="form-check">
                                                    <input class="form-check-input icheck-primary" type="checkbox" value="{{$r}}"
                                                         name="permission[]">
                                                    <label class="form-check-label">
                                                         {{$r}}
                                                    </label>
                                                  </div>
                                           </div>
                                         @endforeach

                                     </div> <br>
                                     @foreach ($errors->get('permission') as $message)
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


        <!-- DataTables roles -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#id</th>
                            <th>Role Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($roles as $role)
                        <tr>
                            <td>{!!$loop->iteration!!}</td>
                            <td>{!! $role->name !!}</td>
                            <td style="display: flex">
                                <form action='{{route('superAdmin.role.destroy',[$role])}}' method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button style="margin-bottom: 5px;" onclick="return confirm('Are you ready want to delete this role ?')" name="delete" value="1"
                                        class="btn btn-danger btn-sm"><i class="fas fa-fw fa-user-minus"></i></button>

                                </form>
                                <button style="margin-bottom: 5px; margin-left:5px" id="edit" data-role="edit" data-toggle="modal"
                                    data-target="#editrole-{!!$role->id!!}" value="1" class="btn btn-info btn-sm">
                                    <i class="fas fa-fw fa-user-edit"></i>
                                </button>
                            </td>
                            <!-- Edit role Modal -->

                            <div class="modal fade bd-example-modal-lg" id="editrole-{!!$role->id!!}" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="edit-label-">Edit role</h5>
                                            <button class="close" type="button" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form id="form-edit-1" action="{{route('superAdmin.role.update',[$role])}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" id="1" />
                                            <div class="modal-body">
                                                <div class="col-md-12">
                                                    <select name="name" class="form-control" id="name">
                                                        <option value="admin" class="p-2" @if($role->name == 'admin') selected @endif>
                                                            Admin </option>
                                                        <option value="user" class="p-2" @if($role->name == 'user') selected @endif>
                                                            User </option>
                                                    </select> <br>
                                                    @foreach ($errors->get('name') as $message)
                                                    <span class="error">
                                                        {{ $message }}*
                                                    </span>
                                                   @endforeach

                                                        <p>Choose Permission For Rule:</p>
                                                        <div class="row">
                                                            <div class="col-12">
                                                               <div class="form-check">
                                                                   <input class="form-check-input icheck-primary  checkjs" type="checkbox" id="select-all2"
                                                                         >
                                                                   <label class="form-check-label">
                                                                        check All
                                                                   </label>
                                                                 </div>
                                                            </div>
                                                            @foreach (config('Permission') as $r )
                                                              <div class="col-md-4 col-sm-6 col-12">
                                                                     <div class="form-check">
                                                                       <input class="form-check-input icheck-primary" type="checkbox" value="{{$r}}"
                                                                            name="permission[]" @if(in_array($r,$role->permissions)) checked @endif>
                                                                       <label class="form-check-label">
                                                                            {{$r}}
                                                                       </label>
                                                                     </div>
                                                              </div>
                                                            @endforeach
                                                </div> <br>
                                                @foreach ($errors->get('permission') as $message)
                                                <span class="error">
                                                    {{ $message }}*
                                                </span>
                                               @endforeach
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
                        <!-- Edit role Modal -->

                        </form>
            </div>
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
$(document).ready(function() {
    $('.checkjs').each(function() {
        $(this).on('click',function(){
            var checked = this.checked;
        $('input[type="checkbox"]').each(function() {
        this.checked = checked;
        })

    });
    })
});
</script>
@endsection
