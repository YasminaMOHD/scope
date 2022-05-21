@extends('Admin.master')
@section('title','ScopeRealEstate - LeadSystem')
@section('content')
    <div class="container-fluid">
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
                             if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'super-admin'){
                                $count = App\Models\Lead::with('status')
                                    ->where('status_id', $s->id)
                                    ->count();
                                            }else{
                                $l=App\Models\Agents_lead::where('agent_id',App\Models\Agents::where('user_id',Auth::user()->id)->first()->id)->first();
                                if($l != null){
                                   $le=$l->leads;
                               }else{
                                   $le=[];
                               }
                                $count = App\Models\Lead::with('status')
                                    ->where('status_id', $s->id)->whereIn('id',$le)
                                    ->count();
                                $countjs [] = $count;
                            }

                            @endphp
                            <div class="mr-1">{!! $count !!} {!! $s->name !!}</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="{{route('lead.search',['status',$s->id])}}">
                            <span class="float-left">View List</span>
                            <span class="float-right">
                                <i class="fas fa-angle-right"></i>
                            </span>
                        </a>
                    </div>
                </div>
            @endforeach
            </div>
            <br><hr><br>
           @can('create-project')
            <form action="{{route('filter')}}" method="get">
                <select name="agent" id="agent" class="selectpicker form-control mb-3" style="width:27%">
                    <option selected disabled>Select Agent</option>
                    @foreach ($agents as $a)
                    <option value="{{$a->id}}">{{$a->fullName}}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary" name="lead" value="lead">Go To Lead Page</button>
                <button class="btn btn-warning" name="inventory" value="inventory">Go To inventory Page</button>
            </form>
        @endcan

    </div>
    </div>
@endsection
@section('script')
       <!-- Core plugin JavaScript-->
       <script src="{{asset('js/jquery.easing.min.js')}}"></script>

       <!-- Page level plugin JavaScript-->
       <script src="{{asset('js/chart.js/Chart.min.js')}}></script>

    <!-- Demo scripts for this page-->
    <script src="{{asset('js/demo/datatables-demo.js')}}></script>
    <script src="{{asset('js/demo/chart-area-demo.js')}}></script>
@endsection
