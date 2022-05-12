@extends('Admin.master')
@section('title','Agent System - ADMIN')
@section('style')
<link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
@stop
@section('content')
    <div class="container-fluid">
        <!-- DataTables Sellers -->
        <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-4 float-left">
                        <i class="fas fa-fw fa-users"></i>
                        Assign Leads To Agents
                    </div>
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4 float-right">
                        <button type="button" class="btn btn-success btn-sm float-right" href="#" data-toggle="modal"
                            data-target="#createSeller">Assign Leads To Agent <i class="fas fa-fw fa-user-plus"></i></button>
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
            @foreach ($errors->get('agent_id') as $message)
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
                            <h5 class="modal-title" id="exampleModalLabel">Assign Leads To Agent</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{route('admin.agent_lead.store')}}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <label for="selectpicker1">Select Agent</label>
                                    <select name="agent_id" class="selectpicker w-100" id="selectpicker1"required data-live-search="true">
                                        @foreach ($agents as $agent )
                                            <option value="{!!$agent->id!!}">{!!$agent->fullName!!}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <label for="selectpicker2">Select One/Multi Lead</label>
                                    <select name="lead[]" class="selectpicker w-100" id="selectpicker2"required multiple data-live-search="true">
                                        @foreach ($leads as $lead )
                                            <option value="{!!$lead->id!!}">{!!$lead->name!!}</option>
                                        @endforeach
                                    </select>
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
                                <th>Agent</th>
                                <th>Leads</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($agent_lead as $ag)
                            <tr>
                                <td>{!! $loop->iteration !!}</td>
                                <td>{!! $ag->agent ? $ag->agent->fullName : '' !!}</td>
                                @php $le= App\Models\Lead::whereIn('id',$ag->leads)->get(); @endphp
                                <td>
                                    @foreach ($le as $l)
                                        <span style="background: lightgray;padding:8px;">{!!$l->name!!}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="row ml-1">
                                        <div class="col-xs-6 mr-2">
                                            <form action='{{route('admin.agent_lead.destroy',$ag->id)}}' method="post">
                                                @csrf
                                                @method("DELETE")
                                                <button style="margin-bottom: 5px;" type="submit" name="delete" value="{{$ag->id}}"
                                                    class="btn btn-danger btn-sm" onclick="confirm('Are you want to delete this agent leads ?')"><i
                                                        class="fas fa-fw fa-user-minus"></i></button>
                                            </form>
                                        </div>
                                        <div class="col-xs-6">
                                            <button id="edit" data-role="edit" data-toggle="modal"
                                                data-target="#editSeller-{!!$ag->id!!}" value="{!!$ag->i!!}" class="btn btn-info btn-sm"><i
                                                    class="fas fa-fw fa-user-edit"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <!-- Edit Seller Modal -->


                                <!-- End Edit Seller Modal -->
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @foreach ($agent_lead as $ag)
        <div class="modal fade bd-example-modal-lg" id="editSeller-{!!$ag->id!!}" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit-label-">Edit Agent Lead</h5>
                        <button class="close" type="button" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form form="form{!!$ag->id!!}" id="form-edit-{!!$ag->id!!}" action="{{route('admin.agent_lead.update',$ag->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="col-md-12">
                                <label for="selectpicker3">Select Agent</label>
                                <select name="agent_id" class="selectpicker w-100" id="selectpicker3" required data-live-search="true">
                                    @foreach ($agents as $agent )
                                        <option value="{!!$agent->id!!}" @if($agent->id == ($ag->agent ? $ag->agent->id : '')) selected @endif>{!!$agent->fullName!!}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mt-4">
                                {{-- @php $le= App\Models\Lead::whereIn('id',$ag->leads)->get(); @endphp --}}
                                <label for="selectpicker4">Select One/Multi Lead</label>
                                <select name="lead[]" class="selectpicker w-100" id="selectpicker4"required multiple data-live-search="true">
                                    @foreach ($leads as $lead )
                                        <option value="{!!$lead->id!!}"
                                            @if(in_array($lead->id,$ag->leads))
                                                selected
                                            @endif
                                        >{!!$lead->name!!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button"
                                data-dismiss="modal">Cancel</button>
                            <button class="btn btn-success" type="submit" name="update"
                                id="update-{!!$ag->id!!}" value="{!!$ag->id !!}">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
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
    <script src="{{asset('js/bootstrap-select.js')}}"></script>
    <script>
        $(document).ready(function () {
           $('.selectpicker').selectpicker();
        });
    </script>
@endsection
