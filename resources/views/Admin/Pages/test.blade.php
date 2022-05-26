@extends('Admin.master')
@section('title', 'Lead System - ADMIN')
@section('style')
    <link href="{{ asset('icheck-bootstrap.min.css') }}" rel="stylesheet">

    <script src='{{ asset('js/jquery-3.5.1.min.js') }}' type='text/javascript'></script>
    <script src='{{ asset('js/select2.min.js') }}' type='text/javascript'></script>

    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css">
    {{-- <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
<link rel="icon" href="img/favicon.png" type="image/x-icon"> --}}
@endsection
@section('content')
    <div class="container-fluid">
        <!-- DataTables Example -->
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
        @if (Session::has('error'))
            <script>
                $(function() { //ready
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "showDuration": "1000",
                    }
                    toastr.error("{!! Session::get('error') !!}");
                });
            </script>
        @endif


        @foreach ($errors->get('email') as $message)
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
        @foreach ($errors->get('leadtel') as $message)
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
        @foreach ($errors->get('leadname') as $message)
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
        @foreach ($errors->get('leadaddress') as $message)
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
        @foreach ($errors->get('leadphone') as $message)
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

        <div class="row">
            <div class="col-md-12 col-12">
                <div class="row">
                    @foreach ($status as $s)
                        <div class="col-xl-2 col-md-3 col-6 col-sm-6 mb-3 p-1" style="min-height: 125px;">
                            <div class="card text-white o-hidden h-100" style="background-color: {!! $s->color !!}">
                                <div class="card-body">
                                    <div class="card-body-icon">
                                        {!! $s->icon !!}
                                    </div>
                                    @php
                                        if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'super-admin') {
                                            $count = App\Models\Lead::with('status')
                                                ->where('status_id', $s->id)
                                                ->count();
                                        } else {
                                            $l = App\Models\Agents_lead::where('agent_id', App\Models\Agents::where('user_id', Auth::user()->id)->first()->id)->first();
                                            if ($l != null) {
                                                $le = $l->leads;
                                            } else {
                                                $le = [];
                                            }
                                            $count = App\Models\Lead::with('status')
                                                ->where('status_id', $s->id)
                                                ->whereIn('id', $le)
                                                ->count();
                                            $countjs[] = $count;
                                        }

                                    @endphp
                                    <div class="mr-1">{!! $count !!} {!! $s->name !!}</div>
                                </div>
                                <a class="card-footer text-white clearfix small z-1"
                                    href="{{ route('lead.search', ['status', $s->id]) }}">
                                    <span class="float-left">View List</span>
                                    <span class="float-right">
                                        <i class="fas fa-angle-right"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header mb-3">
                <div class="row">
                    <div class="col-md-2 float-left">
                        <i class="fas fa-fw fa-users"></i>
                        Leads List
                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-6 float-right">
                        <div style="z-index: 9999;">
                            <button type="button" style="margin-left: 10px" class="btn btn-success btn-sm float-right"
                                href="#" data-toggle="modal" data-target="#createlead">Add lead <i
                                    class="fas fa-fw fa-user-plus"></i></button>
                            <a style="margin-left: 10px; z-index: 99999;" class="btn btn-danger btn-sm float-right"
                                href="{{ route('lead.trash') }}">Trash <i class="fas fa-fw fa-trash"></i></a>
                            <button type="button" style="margin-left: 10px; z-index: 99999;"
                                class="btn btn-outline-dark btn-sm float-right" href="#" data-toggle="modal"
                                data-target="#byuser">Select By <i class="fas fa-fw fa-users"></i></button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Create lead -->
            <!-- Large modal -->
            <div class="modal fade bd-example-modal-lg" id="createlead" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create New lead</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{ route('lead.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <input style="margin-bottom: 15px;" type="text" id="leadname" class="form-control"
                                        name="leadname" placeholder="Lead name" required="">
                                    <input style="margin-bottom: 15px;" type="email" id="leademail" class="form-control"
                                        name="email" placeholder="Lead email" required="">
                                    <input style="margin-bottom: 15px;" type="tel" id="leadphone" class="form-control"
                                        name="leadphone" pattern="+[0-9]{12}" placeholder="Lead Phone Number" required="">
                                    <input style="margin-bottom: 15px;" type="text" id="address" class="form-control"
                                        name="leadaddress" placeholder="Lead Address" required="">

                                    <div class="project-sec">
                                        <select class="projectState form-control" style="margin-bottom: 15px;"
                                            name="leadproject" required="">
                                            <option disabled="" value="" selected="" name="leadproject">Select Project
                                            </option>
                                            <option value="other" class="disothr">Other Project</option>
                                            @foreach ($projects as $project)
                                                <option value="{!! $project->id !!}">{!! $project->name !!}</option>
                                            @endforeach
                                        </select>
                                        <input style="margin-bottom: 15px;" type="text" id="other"
                                            class="otherproject form-control" name="leadproject" placeholder="Other Project"
                                            disabled>
                                    </div>
                                    <div class="campagin-sec">
                                        <select class="campagineState form-control" style="margin-bottom: 15px;"
                                            name="leadcampagin">
                                            <option disabled="" value="" selected="" name="leadcampagin">Select Campagine
                                            </option>
                                            <option value="other" class="disothr">Other Campaign</option>
                                            @foreach ($campagines as $campagine)
                                                <option value="{!! $campagine->id !!}" style="display: flex">
                                                    <span>{!! $campagine->name !!}</span> : <span></span>
                                                    <span>{!! $campagine->source !!}</span>
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="row">
                                            <div class="col-12">
                                                <label style="color:red;">Other campagine&source*</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input style="margin-bottom: 15px;" type="text" id="campagine"
                                                    class="other form-control" name="leadcampagin"
                                                    placeholder="Lead Campagine" disabled>
                                            </div>
                                            <div class="col-md-6">
                                                <input style="margin-bottom: 15px;" type="text" id="source"
                                                    class="other form-control" name="leadsource" placeholder="Lead Source"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <input class="btn btn-success" type="submit" name="submit" value="Confirm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade bd-example-modal-lg" id="byuser" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Show by Project</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="col-md-12">
                                <!-- Icon Cards-->
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-project-tab" data-toggle="tab"
                                            href="#nav-project" role="tab" aria-controls="nav-project"
                                            aria-selected="true">Project</a>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-project" role="tabpanel"
                                        aria-labelledby="nav-project-tab">
                                        <div class="row mt-3">
                                            <div class="col-12 mb-5">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <input class="form-control float-right" style="min-width: 350px;"
                                                        id="filterproject" placeholder="Search for a Project HERE"
                                                        type="text">
                                                </div>
                                            </div>
                                            <script>
                                                $("#filterproject").keyup(function() {
                                                    var filter = $(this).val(),
                                                        count = 0;
                                                    $('.projectdiv').each(function() {
                                                        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                                                            $(this).hide();
                                                        } else {
                                                            $(this).show();
                                                            count++;
                                                        }
                                                    });
                                                });
                                            </script>
                                            @foreach ($projects as $project)
                                                <div class="col-xl-4 col-sm-8 mb-6 projectdiv" style="margin-bottom: 10px">
                                                    <div class="card text-white bg-secondary o-hidden h-100 projectdiv"
                                                        style="padding: 2px 2px 2px 2px !important;">
                                                        <a style="margin: 2px 2px 2px 2px !important;"
                                                            class="card-footer text-white clearfix small z-1"
                                                            href="{{ route('lead.search', ['project', $project->id]) }}">
                                                            <span style="font-size: 16px"
                                                                class="float-left">{!! $project->name !!}</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($leads as $lead)
                <div id="modalsOutTable">

                    <!-- History -->
                    <!-- Large modal -->
                    <div class="modal fade bd-example-modal-lg" id="history-{!! $lead->id !!}" tabindex="-1"
                        role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">History</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="col-md-12">
                                        <div class="edit-2">
                                            @foreach ($lead->desc as $desc)
                                                <div class="p-2 mb-2 rounded bg-secondary">
                                                    <div class="edit-desc mb-3" style="display: none">
                                                        <div>
                                                            <textarea class="w-100 desc" name="desc">{!! $desc->text !!}</textarea>
                                                            <button value="{!! $desc->id !!}"
                                                                class="updatedesc btn btn-hover btn-primary">edit</button>
                                                        </div>
                                                    </div>
                                                    <div class="p-1 mb-4 bg-light rounded textedit">
                                                        {!! $desc->text !!} </div>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="by-class">
                                                                @php
                                                                    $user = App\Models\User::find($desc->user_id);
                                                                @endphp
                                                                Edited by: {!! $user ? $user->name : '' !!} </div>
                                                            <div class="date-class">
                                                                {!! $desc->created_at !!} </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="icons"
                                                                style="display: flex;  flex-direction: row-reverse;">
                                                                <button class="editbtndesc ml-1"
                                                                    style="border-radius: 50%"><i
                                                                        class="fas fa-pencil-alt prefix"></i></button>
                                                                {{-- <form action=""> --}}
                                                                <button class="deldesc ml-1" style="border-radius: 50%"
                                                                    value="{!! $desc->id !!}"><i
                                                                        class="fas fa-fw fa-trash"></i></button>
                                                                {{-- </form> --}}
                                                                <button class="select_reminder"
                                                                    style="border-radius: 50%"><i class="fas fa-clock"></i></button>
                                                                <div class="change w-75" style="display: none">
                                                                    <span style="color: #fff">Last Reminder :
                                                                        <br>{!! $desc->reminder_at !!}</span>
                                                                    <input type="datetime-local"
                                                                        value="{!! date('m-d-Y H:m:s', strtotime($desc->reminder_at)) !!}" name='reminder'
                                                                        class="reminder">
                                                                    <button class="btn btn-primary w-75 mt-1 saveReminder"
                                                                        value="{!! $desc->id !!}">save time</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <!--Textarea with icon prefix-->
                                        <form id="form-desc-23401" action="{{ route('lead.desc', $lead->id) }}"
                                            method="POST">
                                            @csrf
                                            <div class="md-form amber-textarea active-amber-textarea"
                                                style="margin-bottom: 25px;">
                                                <i class="fas fa-pencil-alt prefix"
                                                    style="position: absolute; float: right; right: 10px !important;"></i>
                                                <textarea name="newDescription" id="" class="md-textarea form-control" rows="3"
                                                    placeholder="Write description here ..."></textarea>
                                                <!-- <label for="form-desc-">Write description here ...</label> -->
                                            </div>
                                    </div>

                                    @foreach ($status as $s)
                                        <div class="radio icheck-primary d-inline">
                                            <input type="radio" onclick="dynInput(this,{!! $lead->id !!})"
                                                id="primary-{!! $lead->id !!}" name="lead_status"
                                                value="{!! $s->id !!}"
                                                @if ($lead->status->id == $s->id) checked @endif required="">
                                            <label for="primary-{!! $lead->id !!}">{!! $s->name !!}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <style>
                                    .icons button {
                                        height: 30px;
                                        font-size: 14px;

                                        text-align: center;
                                        color: #fff;
                                        border: none;
                                        width: 30px;
                                    }

                                    .deldesc {
                                        background-color: red;
                                    }

                                    .editbtndesc {
                                        background: lightblue;
                                        color: #000
                                    }
                                    .select_reminder{
                                        background: #00c853;
                                        color: #fff;
                                    }

                                </style>

                                <div class="modal-footer">
                                    <div id="amount-23401">
                                    </div>
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <input class="btn btn-success" type="submit" name="add_desc" value="Confirm">
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- lead assign -->
                <div class="modal fade bd-example-modal-lg" id="assign-{!! $lead->id !!}" tabindex="-1"
                    role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="edit-label-">Assign Lead To Agent</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form form="form{!! $lead->id !!}" id="form-edit-{!! $lead->id !!}"
                                action="{{ route('lead.assign', $lead->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="col-md-12">
                                        <label for="selectpicker3">Select Agent</label>
                                        <select name="agent_id" class="selectpicker w-100" id="selectpicker3" required
                                            data-live-search="true">
                                            <option  disabled>select Agent</option>
                                            @php
                                             $agen = App\Models\Agents_lead::get();
                                                    foreach ($agen as $a) {
                                                           if (in_array(($lead->id), $a->leads)) {
                                                               $agent_name = App\Models\Agents::where('id', $a->agent_id)->first();
                                                               $agent_name = $agent_name ? $agent_name->id : '';
                                                                break;
                                                            } else {
                                                              $agent_name = '';
                                                          }
                                                        }
                                             @endphp
                                            @foreach ($agents as $agent)
                                                <option value="{!! $agent->id !!}"
                                                    @if ($agent->id == $agent_name) selected @endif>
                                                    {!! $agent->fullName !!}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <button class="btn btn-success" type="submit" name="update"
                                        id="update-{!! $lead->id !!}"
                                        value="{!! $lead->id !!}">Confirm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Edit Lead Modal -->
                <div class="modal fade bd-example-modal-lg" id="editLead-{!! $lead->id !!}" tabindex="-1"
                    role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="edit-label-">Edit Lead Informations</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form id="form-edit-{!! $lead->id !!}" action="{{ route('lead.update', $lead->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="col-md-12">
                                        <input style="margin-bottom: 15px;" type="text"
                                            id="leadname-{!! $lead->id !!}" class="form-control" name="leadname"
                                            placeholder="Lead Full Name: Firstname Lastname"
                                            value="{!! $lead->name !!}" required="">
                                        <input style="margin-bottom: 15px;" type="email"
                                            id="leademail-{!! $lead->id !!}" name="email" class="form-control"
                                            placeholder="Lead email address" value="{!! $lead->email !!}" required="">
                                        <input style="margin-bottom: 15px;" type="tel" id="leadtel-{!! $lead->id !!}"
                                            name="leadtel" class="form-control" pattern="+[0-9]{12}"
                                            placeholder="Lead phone number" value="{!! $lead->phone !!}" required="">
                                        <input style="margin-bottom: 15px;" type="text"
                                            id="leadaddress-{!! $lead->id !!}" name="leadaddress"
                                            class="form-control" placeholder="Lead Personal Address"
                                            value="{!! $lead->address !!}" required="">
                                        <input style="margin-bottom: 15px;" type="text"
                                            id="leaddate-{!! $lead->id !!}" name="leaddate" class="form-control"
                                            placeholder="Lead Date" value="{!! $lead->created_at !!}" hidden="">
                                        <div class="project-sec">
                                            <select class="projectState form-control" style="margin-bottom: 15px;"
                                                name="leadproject" required="">
                                                <option value="other" class="disothr">Other Project</option>
                                                @foreach ($projects as $project)
                                                    <option value="{!! $project->id !!}"
                                                        @if (($lead->project ? $lead->project->id : '') == $project->id) selected @endif>
                                                        {!! $project->name !!}</option>
                                                @endforeach
                                            </select>
                                            <input style="margin-bottom: 15px;" type="text" id="other"
                                                class="otherproject form-control" name="leadproject"
                                                placeholder="Other Project" disabled required>
                                        </div>
                                        <div class="campagin-sec">
                                            <select class="campagineState form-control" style="margin-bottom: 15px;"
                                                name="leadcampagin">
                                                <option value="other" name="leadcampagin" class="disothr">Other
                                                    Campagine</option>
                                                @foreach ($campagines as $campagine)
                                                    <option value="{!! $campagine->id !!}"
                                                        @if (($lead->campagines ? $lead->campagines->id : '') == $campagine->id) selected @endif>
                                                        <span>{!! $campagine->name !!}</span> : <span></span>
                                                        <span>{!! $campagine->source !!}</span>
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label style="color:red;">Other campagine&source*</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input style="margin-bottom: 15px;" type="text" id="campagine" required
                                                        class="other form-control" name="leadcampagin"
                                                        placeholder="Lead Campagine" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <input style="margin-bottom: 15px;" type="text" id="source" required
                                                        class="other form-control" name="leadsource"
                                                        placeholder="Lead Source" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <button class="btn btn-success" type="submit" name="update"
                                        id="update-{!! $lead->id !!}"
                                        value="{!! $lead->id !!}">Confirm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Edit lead Modal -->

                <!-- Lead Info Modal -->
                <div class="modal fade bd-example-modal-lg" id="infoLead-{!! $lead->id !!}" tabindex="-1"
                    role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="edit-label-{!! $lead->id !!}">Lead Informations</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="col-md-12">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><i class="fas fa-user"
                                                style="position: relative; left: -25px"> Full Name :</i>
                                            {!! $lead->name !!}
                                        </li>
                                        <li class="list-group-item"><i class="fas fa-map-marker-alt"
                                                style="position: relative; left: -25px"> Address :</i>
                                            {!! $lead->address !!}</li>
                                        <li class="list-group-item"><i class="fas fa-at"
                                                style="position: relative; left: -25px"> Lead email
                                                :</i> {!! $lead->email !!}</li>
                                        <li class="list-group-item"><i class="fas fa-mobile"
                                                style="position: relative; left: -25px"> Lead phone :</i><a
                                                href="tel:{!! $lead->phone !!}"> {!! $lead->phone !!}</a></li>
                                        <li class="list-group-item"><i class="fas fa-calendar-day"
                                                style="position: relative; left: -25px"> Submitted on :</i>
                                            {!! $lead->created_at !!}</li>

                                        <li class="list-group-item"><i class="fas fa-info"
                                                style="position: relative; left: -25px"> Lead Status :</i>
                                            <div class="btn @if ($lead->status->name == 'No Answer') btn-primary @elseif($lead->status->name == 'Potential') btn-light
                                                    @elseif($lead->status->name == 'Follow Up') btn-warning @elseif($lead->status->name == 'Undefined') btn-secondary
                                                    @elseif($lead->status->name == 'Unsellable customer') btn-danger
                                                    @elseif($lead->status->name == 'Deal')btn-info @else btn-success @endif btn-circle btn-circle-sm m-1"
                                                style="width: 120px;">
                                                {!! $lead->status->name ?? '' !!}
                                            </div>
                                        </li>

                                        <li class="list-group-item"><i class="fas fa-comment-dots"
                                                style="position: relative; left: -25px"> Description :</i><br>
                                            @foreach ($lead->desc as $desc)
                                                {!! $desc->text !!} <br>
                                            @endforeach
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-success" type="submit" name="update"
                                    id="update-{!! $lead->id !!}" value="{!! $lead->id !!}">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Lead Info Modal -->
            @endforeach
            <script>
                $(document).ready(function() {
                    function query_string(variable) {
                        var query = window.location.search.substring(1);
                        var vars = query.split("&");
                        for (var i = 0; i < vars.length; i++) {
                            var pair = vars[i].split("=");
                            if (pair[0] == variable) {
                                return pair[1];
                            }
                        }
                        return ("");
                    }

                    var changeModals = function() {
                        $("#modalsOutTable").replaceWith($("#modalsInTable").html());
                    }
                    var st = query_string('st');
                    var uid = query_string('uid');
                    var pid = query_string('pid');


                    //     var funcModals = function() {
                    //         $('#modalsOutTable').html(
                    //             dataTable
                    //             .columns(10)
                    //             .data()
                    //             .eq(0) // Reduce the 2D array into a 1D array of data
                    //             .sort() // Sort data alphabetically
                    //             .unique() // Reduce to unique values
                    //             .join('')
                    //         );
                    //         dataTable.column(10).visible(false);
                    //     }
                    //     $(".datepicker").datepicker({
                    //         "dateFormat": "YYYY-MM-DD"
                    //     });

                });

                // $(document).on('click', '#dateFilterBtn', function() {
                //     // Your Code
                //     var dataTable = $('#dataTable').DataTable();
                //     dataTable.draw();
                // });
            </script>
            <div class="card-body">
                <form id="assignform" method="POST" action=""> </form>
                @csrf
                <fieldset form="assignform">
                    <!-- jQuery UI CSS -->
                    <link rel="stylesheet" type="text/css"
                        href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

                    <!-- jQuery Library -->
                    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
                    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
                    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css">
                    <style>
                        .dateF {
                            /* position: absolute;
                                    top: 85px; */
                            /* align-items: center;
                            text-align: center; */
                        }

                        .gj-datepicker.gj-datepicker-bootstrap.gj-unselectable.input-group {
                            width: 250px !important;
                            margin-right: 10px;
                            display: inline-flex;
                        }

                        input#start-date,
                        input#end-date {
                            height: 30px;
                        }

                        span.input-group-append {
                            height: 30px;
                        }

                        .gj-datepicker-bootstrap [role=right-icon] button .gj-icon,
                        .gj-datepicker-bootstrap [role=right-icon] button .material-icons {
                            position: absolute;
                            font-size: 21px;
                            top: 5px;
                            left: 9px;
                        }

                        #dateFilterBtn {
                            margin-top: -4px;
                            width: 72px;
                            padding-top: 2px;
                            padding-bottom: 2px;
                            height: 30px;
                        }

                        @media only screen and (max-width: 1120px) {
                            .dateF {
                                /* top: 90px; */
                            }

                            .assign-class {
                                top: 185px !important;
                            }
                        }

                        @media only screen and (max-width: 1060px) {
                            .dateF {
                                /* top: 130px; */
                            }

                            .assign-class {
                                top: 185px !important;
                            }
                        }

                        @media only screen and (max-width: 870px) {
                            .dateF {
                                /* top: 150px; */
                            }
                        }

                        @media only screen and (max-width: 767px) {
                            .dateF {
                                /* top: 160px; */
                            }

                            .assign-class {
                                top: 380px !important;
                            }

                            .gj-datepicker.gj-datepicker-bootstrap.gj-unselectable.input-group {
                                width: 160px !important;
                            }
                        }

                        @media only screen and (max-width: 520px) {
                            .dateF {
                                /* top: 120px; */
                            }

                            #dateFilterBtn {
                                margin-top: 0px;
                                float: right;
                                margin-right: 10px;
                            }

                            .gj-datepicker.gj-datepicker-bootstrap.gj-unselectable.input-group {
                                width: 200px !important;
                                margin-left: 65px;
                                margin-bottom: 10px;
                                display: flex;
                            }
                        }

                    </style>
                    <div class="dateF row mb-5">
                        <div class="col-md-8 input-group d-inline date">
                            <form action="{{ route('lead.search') }}" class="w-100" method="GET">
                                <div role="wrapper"
                                    class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group">
                                    <input type="text" name="from" id="start-date"
                                        class="datepicker startdate d-inline form-control" placeholder="From date">
                                </div>
                                <div role="wrapper"
                                    class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group">
                                    <input type="text" name="to" id="end-date"
                                        class="datepicker enddate d-inline form-control" placeholder="To date">
                                </div>
                                <input type="submit" name="filter" value="Filter" class="btn btn-info btnDate">
                            </form>

                        </div>
                        <div class="col-md-4 mt-3" >
                            <form action="{{ route('destroyall') }}" method="GET" style="display: flex">
                                <input type="text" value="" name="deleteLeads" class="del-all form-control w-50 mr-2"  >
                                <button class="btn btn-danger">Delete All</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive toptab">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered dataTable no-footer" id="dataTable" width="100%"
                                        cellspacing="0" role="grid">
                                        <thead>
                                            <tr role="row">
                                                <th style="width: 25px" class="sorting_desc" tabindex="0"
                                                    aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="descending"
                                                    aria-label="#: activate to sort column ascending"># <input type="checkbox" name="check[]" class="checkAll"></th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Lead Name: activate to sort column ascending">Lead Name</th>
                                                    <th style="width: fit-content" class="sorting" tabindex="0"
                                                    aria-controls="dataTable" rowspan="1" colspan="1"
                                                    aria-label="Phone: activate to sort column ascending">Phone</th>
                                                    <th style="width: fit-content" class="sorting" tabindex="0"
                                                    aria-controls="dataTable" rowspan="1" colspan="1"
                                                    aria-label="Date: activate to sort column ascending">Date</th>
                                                    <th style="width: fit-content" class="sorting" tabindex="0"
                                                    aria-controls="dataTable" rowspan="1" colspan="1"
                                                    aria-label="Phone: activate to sort column ascending">Email</th>

                                                    <th style="width: fit-content" class="sorting" tabindex="0"
                                                    aria-controls="dataTable" rowspan="1" colspan="1"
                                                    aria-label="Source: activate to sort column ascending">Source</th>
                                                @can('view-agent')
                                                <th style="width: fit-content" class="sorting" tabindex="0"
                                                    aria-controls="dataTable" rowspan="1" colspan="1"
                                                    aria-label="Campaign: activate to sort column ascending">Campaign</th>
                                                 @endcan


                                                <th style="width: fit-content" class="sorting" tabindex="0"
                                                    aria-controls="dataTable" rowspan="1" colspan="1"
                                                    aria-label="Project: activate to sort column ascending">Project</th>
                                                    @can('view-agent')
                                                <th style="width: fit-content" class="sorting" tabindex="0"
                                                    aria-controls="dataTable" rowspan="1" colspan="1"
                                                    aria-label="Project: activate to sort column ascending">Agent</th>
                                                    @endcan
                                                <th style="width: 25px;" class="sorting" tabindex="0"
                                                    aria-controls="dataTable" rowspan="1" colspan="1"
                                                    aria-label="Status: activate to sort column ascending">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Actions: activate to sort column ascending">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($leads as $lead)
                                                <tr role="row" class="odd">
                                                    <td class="sorting_1">
                                                        <input class="checkrow" form="assignform"
                                                            style="margin-right: 2px" type="checkbox" name="selectedLead[]"
                                                            value="{!! $lead->id !!}"> {!! $loop->iteration !!}
                                                    </td>
                                                    <td>{!! $lead->name !!}</td>
                                                    <td><a href="tel:{!! $lead->phone !!}">{!! $lead->phone !!}</a></td>
                                                    <td>{!! $lead->created_at !!}</td>
                                                </td>

                                                        <td><a href="mailto:{!! $lead->email ?? ' ' !!}"
                                                            target="_blank">{!! $lead->email ?? '' !!}</a></td>

                                                    <td>{!! $lead->Campagines ? $lead->Campagines->source : 'empty' !!}</td>
                                                    @can('view-agent')
                                                    <td>{!! $lead->Campagines ? $lead->Campagines->name : 'empty' !!}</td>
                                                    @endcan

                                                    <td>{!! $lead->project->name ?? '' !!}</td>
                                                    @can('view-agent')
                                                    @php $agen = App\Models\Agents_lead::get();
                                                                                                                $agent_name = '';
                                                                                                                foreach ($agen as $a) {
                                                                                                                    if (in_array($lead->id, $a->leads)) {
                                                                                                                        $agent_name = App\Models\Agents::where('id', $a->agent_id)->first();
                                                                                                                        $agent_name = $agent_name ? $agent_name->fullName : '';
                                                                                                                        break;
                                                                                                                    } else {
                                                                                                                        $agent_name = '';
                                                                                                                    }
                                                                                                                }
                                                                                                        @endphp
                                                    <td>{!! $agent_name !!}</td>
                                                    @endcan
                                                    <td>
                                                        <div class="btn @if ($lead->status->name == 'No Answer') btn-primary @elseif($lead->status->name == 'Potential') btn-light
                                                    @elseif($lead->status->name == 'Follow Up') btn-warning @elseif($lead->status->name == 'Undefined') btn-secondary
                                                    @elseif($lead->status->name == 'Unsellable customer') btn-danger
                                                    @elseif($lead->status->name == 'Deal') btn-info @elseif($lead->status->name == 'Meeting') btn-success @else btn-dark  @endif
                                                     btn-circle btn-circle-sm m-1"
                                                            style="width: 120px;">@if($lead->status->name == 'Unsellable customer')junk @else{!! $lead->status->name ?? '' !!} @endif</div>
                                                    </td>
                                                    <td>
                                                        <ul style="
                                                                 list-style-type: none;
                                                                 text-align: center;
                                                                 margin: 0;
                                                                 padding: 0;
                                                                 /* display:flex */
                                                           ">
                                                           <div class="dispaly-icon" style="display:flex">
                                                            @can('view-agent')
                                                                <li
                                                                    style="display: inline-block;margin-right: 10px; margin-bottom: 5px">
                                                                    <button id="assign" data-role="assign" data-toggle="modal"
                                                                        data-target="#assign-{!! $lead->id !!}"
                                                                        value="{!! $lead->id !!}"
                                                                        class="btn btn-warning btn-sm">
                                                                        <i class="fas fa-arrow-right"></i>
                                                                    </button>
                                                                </li>
                                                            @endcan
                                                            <li
                                                                style="display: inline-block;margin-right: 10px; margin-bottom: 5px">
                                                                <button id="edit" data-role="edit" data-toggle="modal"
                                                                    data-target="#editLead-{!! $lead->id !!}"
                                                                    value="{!! $lead->id !!}"
                                                                    class="btn btn-secondary btn-sm">
                                                                    <i class="fas fa-fw fa-user-edit"></i>
                                                                </button>
                                                            </li>
                                                            <li
                                                                style="display: inline-block;margin-right: 10px; margin-bottom: 5px">
                                                                <button style="width: 36px;" id="info" data-role="info"
                                                                    data-toggle="modal"
                                                                    data-target="#infoLead-{!! $lead->id !!}"
                                                                    value="{!! $lead->id !!}"
                                                                    class="btn btn-info btn-sm">
                                                                    <i class="fas fa-file-invoice"></i>
                                                                </button>
                                                            </li>
                                                            </div>
                                                            <div class="dispaly-icon" style="display:flex">
                                                            <li
                                                                style="display: inline-block; margin-right: 10px;  margin-bottom: 5px">
                                                                <button style="width: 36px;;" type="button"
                                                                    class="btn btn-success btn-sm" href="#"
                                                                    data-toggle="modal"
                                                                    data-target="#history-{!! $lead->id !!}"> <i
                                                                        class="fas fa-history"></i></button>
                                                            </li>
                                                            <li
                                                                style="display: inline-block; margin-right: 10px;  margin-bottom: 5px">
                                                                <form action="{{ route('lead.destroy', $lead->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button style="width: 36px;" type="submit"
                                                                        class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('Are you want to delete lead ?')"><i
                                                                            class="fas fa-fw fa-user-minus"></i></button>
                                                                </form>
                                                            </li>
                                                            </div>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div id="dataTable_processing" class="dataTables_processing card"
                                        style="display: none;">Currently loading leads</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        .btn.btn-circle.btn-circle-sm.m-1 {
                            margin-top: 0px !important;
                            padding: 3px;
                        }

                        .date-filter {
                            position: absolute;
                            left: 35px;
                            top: 70px
                        }

                        #assignTo {
                            margin-left: 10px;
                            top: -2px;
                            width: 382px;
                            max-height: 30px;
                            padding-top: 0px;
                            border-radius: 0.25rem;
                        }

                        #dataTable {
                            margin-top: 45px !important;
                        }

                        .assign-class {
                            position: absolute;
                            float: left;
                            left: 20px;
                            top: 110px
                        }

                        .laptop {
                            display: block;
                        }

                        .tab {
                            display: none;
                        }

                        .mobile {
                            display: none;
                        }

                        .mobile-min {
                            display: none;
                        }

                        @media only screen and (max-width: 950px) {
                            #dataTable {
                                margin-top: 75px !important;
                            }

                            .assign-class {
                                position: absolute;
                                float: left;
                                left: 20px;
                                top: 150px
                            }

                            .toptab {
                                margin-top: 0px !important;
                            }

                            .laptop {
                                display: none;
                            }

                            .tab {
                                display: block;
                            }

                            .mobile {
                                display: none;
                            }

                            .mobile-min {
                                display: none;
                            }
                        }

                        @media only screen and (max-width: 767px) {
                            #dataTable {
                                margin-top: 0px !important;
                            }

                            .assign-class {
                                position: absolute;
                                float: left;
                                left: 20px;
                                top: 130px
                            }

                            .toptab {
                                margin-top: 30px !important;
                            }

                            .laptop {
                                display: none;
                            }

                            .tab {
                                display: none;
                            }

                            .mobile {
                                display: block;
                            }

                            .mobile-min {
                                display: none;
                            }
                        }

                        @media only screen and (max-width: 520px) {
                            #dataTable {
                                margin-top: 0px !important;
                            }

                            .assign-class {
                                position: absolute;
                                float: left;
                                left: 20px;
                                top: 200px
                            }

                            .toptab {
                                margin-top: 30px !important;
                            }

                            .laptop {
                                display: none;
                            }

                            .tab {
                                display: none;
                            }

                            .mobile {
                                display: none;
                            }

                            .mobile-min {
                                display: block;
                            }
                        }

                    </style>


                </fieldset>

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
@if(Auth::user()->user_type != 'user')
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
    @endif
    <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
    <!-- Demo scripts for this page-->
    <script>
        $(document).ready(function() {


            var table = $('#dataTable').DataTable({
                "pageLength": 20,
                 "stateSave": true,
                lengthChange: false,
                buttons: ['copy', 'excel', 'csv', 'pdf', 'colvis']
            });

            table.buttons().container()
                .appendTo('#dataTable_wrapper .col-md-6:eq(0)');
            $('#start-date').datepicker({
                uiLibrary: 'bootstrap4'
            });
            $('#end-date').datepicker({
                uiLibrary: 'bootstrap4'
            });
        });
    </script>
    <script src="{{ asset('js/bootstrap-select.js') }}"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker();

            $('.projectState').on('change', function() {
                var state = $(this).val();
                if (state == 'other') {
                    $(this).find('.disothr').attr("disabled", "disabled");
                    $(this).parent().parent().find('.otherproject').removeAttr("disabled");
                } else {
                    $(this).find('.disothr').removeAttr("disabled");
                    $(this).parent().parent().find('.otherproject').attr("disabled", "disabled");
                }
            });
            $('.campagineState').on('change', function() {
                var state = $(this).val();
                if (state == 'other') {
                    $(this).find('.disothr').attr("disabled", "disabled");
                    $(this).parent().parent().find('.other').removeAttr("disabled");
                } else {
                    $(this).find('.disothr').removeAttr("disabled");
                    $(this).parent().parent().find('.other').attr("disabled", "disabled");
                }
            });


        });
    </script>
    <script>
        $(document).on('click', '.deldesc', function(e) {
            e.preventDefault();
            if(confirm("Are you want to delete description ?") == true){
            var id = $(this).val();
            var desc = $(this).parent().parent().parent().parent().parent();
            var info = '';
            $.ajax({
                url: "{{ route('lead.desc.delete') }}",
                method: 'get',
                data: {
                    'id': id,
                },
                success: function(data) {
                        desc.html("");
                        for (var count in data) {
                            //    console.log(data[count]);
                            info += '<div class="p-2 mb-2 rounded bg-secondary">' +
                                '<div class="edit-desc mb-3" style="display: none">' +
                                '<div>' +
                                '<textarea  class="w-100 desc" name="desc">' + data[count]
                                .text + '</textarea>' +
                                '<button  value="' + data[count].id +
                                '" class="updatedesc btn btn-hover btn-primary" >edit</button>' +
                                '</div>' + '</div>' +
                                '<div class="p-1 mb-4 bg-light rounded textedit">' + data[count]
                                .text +
                                '</div>' + '<div class="row">' + '<div class="col-sm-6">' +
                                '<div class="by-class">';

                            info += ' Edited by:  ' + data[count].user.name + ' </div>' +
                                '<div class="date-class">' + data[count].created_at + '</div>' +
                                '</div>' +
                                '<div class="col-sm-6">' +
                                '<div class="icons" style="display: flex;  flex-direction: row-reverse;">' +
                                '<button class="editbtndesc ml-1" style="border-radius: 50%"><i class="fas fa-pencil-alt prefix"></i></button>' +
                                '{{-- <form action=""> --}}' +
                                '<button class="deldesc ml-1" style="border-radius: 50%"  value="' +
                                data[count].id +
                                '"><i class="fas fa-fw fa-trash"></i></button>' +
                                '{{-- </form> --}}' +
                                '<button class="select_reminder" style="border-radius: 50%"><i class="fas fa-clock"></i></button>'+
                            '<div class="change w-75" style="display: none">'+
                                ' <span style="color: #fff">Last Reminder : '+
                                    ' <br>'+data[count].reminder_at+'</span> '+
                                    ' <input type="datetime-local"'+
                                   ' name="reminder"'+
                                    'class="reminder">'+
                                    '<button class="btn btn-primary w-75 mt-1 saveReminder"'+
                                    ' value="'+data[count].id+'">save time</button>'+
                             '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';

                        }
                        desc.html(info);
                    },
                error: function(response) {
                    alert('error');
                }
            });
        }
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.editbtndesc', function() {
                $(this).parent().parent().parent().parent().find('.rounded').fadeToggle();
                $(this).parent().parent().parent().parent().find('.edit-desc').fadeToggle();
            });

            $(document).on('click', '.updatedesc', function(e) {
                e.preventDefault();
                var id = $(this).val();
                var descblock = $(this).parent().parent().parent().parent();
                var desc = $(this).parent().find('.desc').val()
                var t = $(this).parent().parent().parent().find('.textedit').html();
                var info = '';
                $.ajax({
                    url: "{{ route('lead.desc.update') }}",
                    method: 'get',
                    data: {
                        'id': id,
                        'desc': desc
                    },
                    success: function(data) {
                        descblock.html("");
                        for (var count in data) {
                            //    console.log(data[count]);

                            info += '<div class="p-2 mb-2 rounded bg-secondary">' +
                                '<div class="edit-desc mb-3" style="display: none">' +
                                '<div>' +
                                '<textarea  class="w-100 desc" name="desc">' + data[count]
                                .text + '</textarea>' +
                                '<button  value="' + data[count].id +
                                '" class="updatedesc btn btn-hover btn-primary" >edit</button>' +
                                '</div>' + '</div>' +
                                '<div class="p-1 mb-4 bg-light rounded textedit">' + data[count]
                                .text +
                                '</div>' + '<div class="row">' + '<div class="col-sm-6">' +
                                '<div class="by-class">';

                            info += ' Edited by:  ' + data[count].user.name + ' </div>' +
                                '<div class="date-class">' + data[count].created_at + '</div>' +
                                '</div>' +
                                '<div class="col-sm-6">' +
                                '<div class="icons" style="display: flex;  flex-direction: row-reverse;">' +
                                '<button class="editbtndesc ml-1" style="border-radius: 50%"><i class="fas fa-pencil-alt prefix"></i></button>' +
                                '{{-- <form action=""> --}}' +
                                '<button class="deldesc ml-1" style="border-radius: 50%"  value="' +
                                data[count].id +
                                '"><i class="fas fa-fw fa-trash"></i></button>' +
                                '{{-- </form> --}}' +
                                '<button class="select_reminder" style="border-radius: 50%"><i class="fas fa-clock"></i></button>'+
                            '<div class="change w-75" style="display: none">'+
                                ' <span style="color: #fff">Last Reminder : '+
                                    ' <br>'+data[count].reminder_at+'</span> '+
                                    ' <input type="datetime-local"'+
                                   ' name="reminder"'+
                                    'class="reminder">'+
                                    '<button class="btn btn-primary w-75 mt-1 saveReminder"'+
                                    ' value="'+data[count].id+'">save time</button>'+
                             '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';

                        }
                        descblock.html(info);
                    },
                    error: function(response) {
                        alert('error');
                    }
                });
            });
            $(document).on('click','.icons .select_reminder',function() {
                $(this).parent().find('.change').fadeToggle();
            });
            $(document).on('click', '.saveReminder', function(e) {
                e.preventDefault();
                var id = $(this).val();
                var descblock = $(this).parent().parent().parent().parent().parent();
                var desc = $(this).parent().find('.reminder').val()
                var info = '';
                $.ajax({
                    url: "{{ route('lead.desc.reminder') }}",
                    method: 'get',
                    data: {
                        'id': id,
                        'desc': desc
                    },
                    success: function(data) {
                        descblock.html("");
                        for (var count in data) {
                            info += '<div class="mb-2 rounded bg-secondary">' +
                                '<div class="edit-desc mb-3" style="display: none">' +
                                '<div>' +
                                '<textarea  class="w-100 desc" name="desc">' + data[count]
                                .text +
                                '</textarea>' +
                                '<button  value="' + data[count].id +
                                '" class="updatedesc btn btn-hover btn-primary" >edit</button>' +
                                '</div>' + '</div>' +
                                '<div class="p-1 mb-4 bg-light rounded textedit">' +
                                data[count].text +
                                '</div>' + '<div class="row">' + '<div class="col-sm-6">' +
                                '<div class="by-class">';

                            info += ' Edited by:  ' + data[count].user.name + ' </div>' +
                                '<div class="date-class">' + data[count].created_at + '</div>' +
                                '</div>' +
                                '<div class="col-sm-6">' +
                                '<div class="icons" style="display: flex;  flex-direction: row-reverse;">' +
                                '<button class="editbtndesc ml-1" style="border-radius: 50%"><i class="fas fa-pencil-alt prefix"></i></button>' +
                                '{{-- <form action=""> --}}' +
                                '<button class="deldesc  ml-1" style="border-radius: 50%"  value="' +
                                data[
                                    count].id +
                                '"><i class="fas fa-fw fa-trash"></i></button>' +
                                '{{-- </form> --}}' +
                                '<button class="select_reminder" style="border-radius: 50%"><i class="fas fa-clock"></i></button>'+
                            '<div class="change w-75" style="display: none">'+
                                ' <span style="color: #fff">Last Reminder : '+
                                    ' <br>'+data[count].reminder_at+'</span> '+
                                    ' <input type="datetime-local"'+
                                   ' name="reminder"'+
                                    'class="reminder">'+
                                    '<button class="btn btn-primary w-75 mt-1 saveReminder"'+
                                    ' value="'+data[count].id+'">save time</button>'+
                             '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';

                        }
                        descblock.html(info);

                    },
                    error: function(response) {
                        alert('error');
                    }
                });
            });


                                                            $(document).on('change','.checkrow',function(e){
    e.preventDefault()
    var checked = $(this).is(':checked');
    if(checked){
          $(this).prop('selected',true);
          $('.del-all').val($('.del-all').val()+$(this).val()+',')
     }else{
         var p= $('.del-all').val()
         var pArray=p.split(',')
         var r=[];
        //  console.log(pArray)
         for(var s in pArray){
             if(pArray[s] != $(this).val()){
                  r.push(pArray[s])
             }
         }
        var newValue=r.join(',')
        $('.del-all').val(newValue)
     }
    });
     $(document).on('change','.checkAll',function(e){
    e.preventDefault()
    var checked = $(this).is(':checked');
    var p= $('.del-all').val()
         var pArray=p.split(',')
         var r=[];
    if(checked){
        $('.checkrow').each(function(){
        $(this).prop("checked", true);
        for(var s in pArray){
             if(pArray[s] != $(this).val()){
                r.push($(this).val())
                break
             }
         }
        })
         var newValue=r.join(',')
        $('.del-all').val(newValue)
     }else{
        $('.checkrow').each(function(){
        $(this).prop("checked", false);
         for(var s in pArray){
            if(pArray[s] == $(this).val()){
                r.pop($(this).val())
                // break
             }
         }
         $('.del-all').val(r)
    })
     }
})
        });
    </script>
@endsection
