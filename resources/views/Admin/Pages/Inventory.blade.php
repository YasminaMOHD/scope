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
                        Inventory List
                    </div>
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4 float-right">
                        <button type="button" class="btn btn-success btn-sm float-right" href="#" data-toggle="modal"
                            data-target="#createSeller">Add inventory Agent <i class="fas fa-fw fa-user-plus"></i></button>
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




            <!-- Large modal -->

            <div class="modal fade bd-example-modal-lg" id="createSeller" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create New Inventory Agent</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{route('inventory.store')}}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <textarea style="margin-bottom: 15px;" type="text" class="form-control"
                                        name="text" placeholder="Inventory Agent Description ...." required></textarea>
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
                                <th>user</th>
                                <th>Inventory</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($inventories as $inventory)
                            <tr>
                                <td>{!! $loop->iteration !!}</td>
                                <td>{!! $inventory->agent ? $inventory->agent->name : '' !!}</td>
                                <td>{!! $inventory->text !!}</td>
                                <td>
                                    <div class="row ml-1">
                                        <div class="col-xs-6 mr-2">
                                            <form action='{{route('inventory.destroy',$inventory->id)}}' method="post">
                                                @csrf
                                                @method("DELETE")
                                                <button style="margin-bottom: 5px;"  name="delete" value="{{$inventory->id}}"
                                                    class="btn btn-danger btn-sm" onclick="return confirm('Are you want to delete this Inventory ?')"><i
                                                        class="fas fa-fw fa-user-minus"></i></button>
                                            </form>
                                        </div>
                                        <div class="col-xs-6">
                                            <button id="edit" data-role="edit" data-toggle="modal"
                                                data-target="#editSeller-{!!$inventory->id!!}" value="{!! $inventory->id !!}" class="btn btn-info btn-sm"><i
                                                    class="fas fa-fw fa-user-edit"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <!-- Edit Seller Modal -->

                                <div class="modal fade bd-example-modal-lg" id="editSeller-{!!$inventory->id!!}" tabindex="-1" role="dialog"
                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="edit-label-">Edit Inventory</h5>
                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form id="form-edit-{!!$inventory->id!!}" action="{{route('inventory.update',$inventory)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" id="{!!$inventory->id!!}" />
                                                <div class="modal-body">
                                                    <div class="col-md-12">
                                                        <textarea style="margin-bottom: 15px;" type="text"
                                                            id="companyname-{!!$inventory->id!!}" class="form-control"
                                                            name="text" placeholder="Inventory"
                                                             required>{!!$inventory->text!!}</textarea>

                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button class="btn btn-success" type="submit" name="update"
                                                        id="update-{!!$inventory->id!!}" value="{!!$inventory->agent ? $inventory->agent->id : '' !!}">Confirm</button>
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
