@extends('layouts.app')

@section('page-styles')
<link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap-tablesorter.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#trips">Trips Today</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#history">Trip History</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        @include('passenger.tabs.trips-today')
                        @include('passenger.tabs.trip-history')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('page-scripts')
<script type="text/javascript">
    $(function() {
        console.log('Page-loaded');
    });
</script>
@endsection