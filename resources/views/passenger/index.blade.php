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
                    <h3>{{ (Auth::user()->isPassenger() ? 'Passenger' : 'Driver') }} Dashboard</h3>
                </div>
                <div class="card-body">
                    @include('components.flash')
                    @if(Auth::user()->isPassenger() && !Auth::user()->hasTripToday())
                        <button type="button" class="btn btn-info mb-3 text-white" data-toggle="modal" data-target="#newTripModal">
                            Create New Trip
                        </button>
                    @endif
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
@if(Auth::user()->isPassenger() && !Auth::user()->hasTripToday())
    @include('passenger.create-modal')
@endif
@include('passenger.exclude-form')
@include('passenger.include-form')
@include('trips.comply-modal')
@endsection

@section('page-scripts')
    <script src="{{ asset('js/bootstrap-tablesorter.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-tablesorter.widgets.js') }}"></script>
    @if (Auth::user()->isPassenger())
        <script src="{{ asset('js/moment.js') }}"></script>
        <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
        <script type="text/javascript">
            @if ($errors->any())
                $('#newTripModal').modal('show');
            @endif
            $('#tripdate').datetimepicker({
                format: 'L'
            });
            $('#tripTime').datetimepicker({
                format: 'LT'
            });
        </script>
    @endif
<script type="text/javascript">
    $('.flash-message').delay(10000).fadeOut(1000);
    $('table').tablesorter({
        theme : "bootstrap",
        widgets : ["filter"],
        widgetOptions : {
            // extra css class name (string or array) added to the filter element (input or select)
            filter_cssFilter : 'form-control'
        }
    });
    $('.leave-btn').on('click', function() {
        $('input[name="trip_id"]').val($(this).attr("tripId"));
        $('#exclude_form').submit();
    });
    $('.join-btn').on('click', function() {
        $('input[name="trip_id"]').val($(this).attr("tripId"));
        $('#include_form').submit();
    });
    $('.btn-comply').on('click', function () {
        let uri = $('#complyForm').attr('action');
        let trip_id = $(this).attr('id');
        $('#complyForm').attr('action', uri.replace('trip::id', trip_id));
        $('#complyModal').modal('show');
    });
</script>
@endsection
