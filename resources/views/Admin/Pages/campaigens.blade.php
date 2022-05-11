@extends('Admin.master')
@section('title','Campaigens System - ADMIN')
@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Custom styles for this template-->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endsection
@section('content')
    <div class="container-fluid">

        <!-- DataTables Projects -->
        <div class="card mb-3">
            <div class="card-header bg-info">
                <div class="row justify-content-center d-flex">
                    <span style="color: #FFF; font-weight: bold;">Campaign Statistics ( UTM )</span>
                </div>
            </div>

            <div class="card-body">
                <div id="accordion">

                    @foreach ($projects as $project )
                    <div class="card mb-3">
                        <div class="card-header" id="heading-1">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#project-1"
                                            aria-expanded="true" aria-controls="collapse-1">
                                            {!!$project->name!!} </button>
                                    </h5>
                                </div>
                                <div class="col-6">
                                    @php $projectLeadNo = App\Models\Lead::where('project_id',$project->id)
                                   ->count();
                                     @endphp
                                    <span style="float: right; margin-top: 7px;">Total Leads: <span
                                            style="color: red">{!!$projectLeadNo!!}
                                        </span></span>
                                </div>
                            </div>
                        </div>

                        <div id="project-1" class="collapse" aria-labelledby="heading-1" data-parent="#accordion">
                           @if($projectLeadNo > 0)
                           <div class="card mb-3 p-3">
                            <table  class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Campaign Source</th>
                                            <th>Campaign Name</th>
                                            <th>Number of Leads</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            @foreach ($project->campagine as $campagine )
                                        <tr>
                                            <td>{!!$campagine->source!!}</td>
                                            <td>{!!$campagine->name!!}</td>
                                            @php $leadNo = App\Models\Lead::where('campagine_id',$campagine->id)->count(); @endphp
                                            <td>{!!$leadNo!!}</td>
                                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                            @else
                            <div class="card-body">
                                Nothing to show!
                            </div>
                            @endif

                    </div>
                    @endforeach
                </div>
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
