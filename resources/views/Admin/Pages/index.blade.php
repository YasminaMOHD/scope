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
                                    $count = App\Models\Lead::with('status')
                                        ->where('status_id', $s->id)
                                        ->count();
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
            <button class="btn btn-primary"> <a href="{{route('lead.index')}}" style="color:#fff">Go To Lead Page</a></button>

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
