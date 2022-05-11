@extends('Admin.master')
@section('title', 'Lead System - ADMIN')
@section('style')
    <link href="{{ asset('icheck-bootstrap.min.css') }}" rel="stylesheet">

    <script src='{{ asset('js/jquery-3.5.1.min.js') }}' type='text/javascript'></script>
    <script src='{{ asset('js/select2.min.js') }}' type='text/javascript'></script>

    <link href='{{ asset('css/select2.min.css') }}' rel='stylesheet' type='text/css'>
    {{-- <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
<link rel="icon" href="img/favicon.png" type="image/x-icon"> --}}
@endsection
@section('content')
    <div class="container-fluid">
        <!-- DataTables Example -->
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

        <div class="card mb-3">
            <div class="card-header mb-3">
                <div class="row">
                    <div class="col-md-2 float-left">
                        <i class="fas fa-fw fa-users"></i>
                        Deleted Leads List
                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-6 float-right">
                        <div style="z-index: 9999;">
                                    <a style="margin-left: 10px; z-index: 99999;"
                                    class="btn btn-primary btn-sm float-right" href="{{route('lead.index')}}">
                                        <i class="fas fa-fw fa-users"></i>
                                        Back To Leads List
                                    </a>

                        </div>
                    </div>
                </div>

            </div>

            <!-- Create lead -->
            <div class="card-body">
                <form id="assignform" method="POST" action=""> </form>
                @csrf
                <fieldset form="assignform">
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
                                                    aria-label="#: activate to sort column ascending">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Lead Name: activate to sort column ascending">Lead Name</th>
                                                <th style="width: fit-content" class="sorting" tabindex="0"
                                                    aria-controls="dataTable" rowspan="1" colspan="1"
                                                    aria-label="Source: activate to sort column ascending">Source</th>
                                                <th style="width: fit-content" class="sorting" tabindex="0"
                                                    aria-controls="dataTable" rowspan="1" colspan="1"
                                                    aria-label="Campaign: activate to sort column ascending">Campaign</th>
                                                <th style="width: fit-content" class="sorting" tabindex="0"
                                                    aria-controls="dataTable" rowspan="1" colspan="1"
                                                    aria-label="Date: activate to sort column ascending">Date</th>
                                                <th style="width: fit-content" class="sorting" tabindex="0"
                                                    aria-controls="dataTable" rowspan="1" colspan="1"
                                                    aria-label="Phone: activate to sort column ascending">Phone</th>
                                                <th style="width: fit-content" class="sorting" tabindex="0"
                                                    aria-controls="dataTable" rowspan="1" colspan="1"
                                                    aria-label="Project: activate to sort column ascending">Project</th>
                                                <th style="width: 25px;" class="sorting" tabindex="0"
                                                    aria-controls="dataTable" rowspan="1" colspan="1"
                                                    aria-label="Status: activate to sort column ascending">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Actions: activate to sort column ascending">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach ($leads as $lead )
                                           <tr role="row" class="odd">
                                            <td class="sorting_1">
                                                <input id="checkrow-{!!$lead->id!!}" form="assignform" style="margin-right: 2px"
                                                    type="checkbox" name="selectedLead[]" value="{!!$lead->id!!}"> {!! $loop->iteration !!}
                                                <script type="text/javascript">
                                                    $("#checkrow-{!!$lead->id!!}").change(function() {
                                                        if (this.checked) {
                                                            $("#row-{!!$lead->id!!}").addClass("checkedrow");
                                                        } else {
                                                            $("#row-{!!$lead->id!!}").removeClass("checkedrow");
                                                        }
                                                    });
                                                </script>
                                            </td>
                                            <td>{!!$lead->name!!}</td>
                                            <td>empty</td>
                                            <td>Time Iraq (A)</td>
                                            <td>{!!$lead->created_at!!}</td>
                                            <td><a href="tel:{!!$lead->phone!!}">{!!$lead->phone!!}</a></td>
                                            <td>{!!$lead->project->name ?? '' !!}</td>
                                            <td>
                                                <div class="btn @if($lead->status->name == 'No Answer') btn-primary @elseif($lead->status->name == 'Potential') btn-light
                                                    @elseif($lead->status->name == 'Follow Up') btn-warning @elseif($lead->status->name == 'Undefined') btn-secondrey
                                                    @elseif($lead->status->name == 'Unsellable Customer') btn-danger
                                                    @elseif($lead->status->name == 'Deal')btn-info @else btn-success @endif
                                                     btn-circle btn-circle-sm m-1"
                                                    style="width: 120px;">{!!$lead->status->name ?? '' !!}</div>
                                            </td>
                                            <td>
                                                <a name="restore" class="btn btn-danger" value="{!!$lead->id!!}" href="{{route('lead.restore',$lead->id)}}">Restore</a>
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
                                margin-top: 120px !important;
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
                                margin-top: 160px !important;
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
    <script>
        $(document).ready(function() {

        $('#dataTable').DataTable({
            'dom': 'Bfrtip',
            'buttons': [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            'lengthMenu': [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
        });
    });
    </script>
@endsection
