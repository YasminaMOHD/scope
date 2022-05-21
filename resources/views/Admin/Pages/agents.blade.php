@extends('Admin.master')
@section('title','Agent System - ADMIN')
@section('content')
    <div class="container-fluid">
        <!-- DataTables Sellers -->
        <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-4 float-left">
                        <i class="fas fa-fw fa-users"></i>
                        Sales Agents List
                    </div>
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4 float-right">
                        <button type="button" class="btn btn-success btn-sm float-right" href="#" data-toggle="modal"
                            data-target="#createSeller">Add Sales Agent <i class="fas fa-fw fa-user-plus"></i></button>
                    </div>
                </div>
            </div>
            <!-- Create Selle\ -->
            <!-- tostar bootstrap -->
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


            @foreach ($errors->get('password') as $message)
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
            @foreach ($errors->get('fullname') as $message)
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
            @foreach ($errors->get('phone') as $message)
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
            @foreach ($errors->get('username') as $message)
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
            @foreach ($errors->get('email') as $message)
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
            <!-- Large modal -->

            <div class="modal fade bd-example-modal-lg" id="createSeller" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create New Sales Agent</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{route('admin.agent.store')}}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <input style="margin-bottom: 15px;" type="text" id="fullname" class="form-control @error('fullname') is-invalid @enderror"
                                        name="fullname" placeholder="Sales Agent Full Name" required>
                                        @foreach ($errors->get('fullname') as $message)
                                        <span class="error">
                                            {{ $message }}*
                                        </span>
                                       @endforeach
                                    <input style="margin-bottom: 15px;" type="text" id="username" class="form-control @error('username') is-invalid @enderror"
                                        name="username" placeholder="Username" required>
                                        @foreach ($errors->get('username') as $message)
                                        <span class="error">
                                            {{ $message }}*
                                        </span>
                                        @endforeach
                                    <input style="margin-bottom: 15px;" type="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" placeholder="Email Address" required>
                                        @foreach ($errors->get('email') as $message)
                                            <span class="error">
                                                {{ $message }}
                                            </span>
                                        @endforeach
                                    <input style="margin-bottom: 15px;" type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" placeholder="Password" required>
                                        @foreach ($errors->get('password') as $message)
                                        <span class="error">
                                            {{ $message }}*
                                        </span>
                                        @endforeach
                                    <input style="margin-bottom: 15px;" type="tel" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" pattern="+[0-9]{12}" placeholder="Phone Number" required>
                                        @foreach ($errors->get('phone') as $message)
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


            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#id</th>
                                <th>Username</th>
                                <th>Company Name</th>
                                <th>Full Name</th>
                                <th>Email Address</th>
                                <th>Phone Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($agents as $agent)
                            <tr>
                                <td>{!! $loop->iteration !!}</td>
                                <td>{!! $agent->user->name !!}</td>
                                <td>{!! $agent->companyName !!}</td>
                                <td>{!! $agent->fullName !!}</td>
                                <td>{!! $agent->user->email !!}</td>
                                <td>{!! $agent->phone !!}</td>
                                <td>
                                    <div class="row ml-1">
                                        <div class="col-xs-6 mr-2">
                                            <form action='{{route('admin.agent.destroy',$agent)}}' method="post">
                                                @csrf
                                                @method("DELETE")
                                                <button style="margin-bottom: 5px;" type="submit" name="delete" value="{{$agent->id}}"
                                                    class="btn btn-danger btn-sm" onclick="return confirm('Are you want to delete this agent ?')"><i
                                                        class="fas fa-fw fa-user-minus"></i></button>
                                            </form>
                                        </div>
                                        <div class="col-xs-6">
                                            <button id="edit" data-role="edit" data-toggle="modal"
                                                data-target="#editSeller-{!!$agent->id!!}" value="{!! $agent->id !!}" class="btn btn-info btn-sm"><i
                                                    class="fas fa-fw fa-user-edit"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <!-- Edit Seller Modal -->

                                <div class="modal fade bd-example-modal-lg" id="editSeller-{!!$agent->id!!}" tabindex="-1" role="dialog"
                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="edit-label-">Edit Seller</h5>
                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form id="form-edit-{!!$agent->id!!}" action="{{route('admin.agent.update',$agent)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" id="{!!$agent->id!!}" />
                                                <div class="modal-body">
                                                    <div class="col-md-12">
                                                        <input style="margin-bottom: 15px;" type="text"
                                                            id="companyname-{!!$agent->id!!}" class="form-control"
                                                            name="companyname" placeholder="Company Name"
                                                            value="{!!$agent->companyName!!}" required>
                                                        <input style="margin-bottom: 15px;" type="text" id="fullname-{!!$agent->id!!}"
                                                            class="form-control" name="fullname"
                                                            placeholder="Contact Person Full Name" value="{!!$agent->fullName!!}" required>
                                                        <input style="margin-bottom: 15px;" type="text" id="username-{!!$agent->id!!}"
                                                            class="form-control" name="username"
                                                            placeholder="Username" value="{!!$agent->user ? $agent->user->name : ''!!}" required>
                                                        <input style="margin-bottom: 15px;" type="email" id="email-{!!$agent->id!!}"
                                                            class="form-control" name="email"
                                                            placeholder="Email Address" value="{!!$agent->user ? $agent->user->email : ''!!}"
                                                            required>
                                                        <input style="margin-bottom: 15px;" type="password"
                                                            id="password-{!!$agent->id!!}" class="form-control" name="password"
                                                            placeholder="New Password" required>
                                                        <input style="margin-bottom: 15px;" type="tel" id="phone-{!!$agent->id!!}"
                                                            class="form-control" name="phone" pattern="+[0-9]{12}"
                                                            placeholder="Phone Number" value="{!!$agent->phone!!}" required>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button class="btn btn-success" type="submit" name="update"
                                                        id="update-{!!$agent->id!!}" value="{!!$agent->user->id!!}">Confirm</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Edit Seller Modal -->
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

@endsection
