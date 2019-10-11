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
                    @if(Auth::user()->isPassenger())
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
@include('passenger.create-modal')
@include('passenger.exclude-form')
@include('passenger.include-form')
@endsection

@section('page-scripts')
<script src="{{ asset('js/moment.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-tablesorter.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-tablesorter.widgets.js') }}"></script>
<script type="text/javascript">
    $(function() {
        @if ($errors->any())
            $('#newTripModal').modal('show');
        @endif
        $('#tripdate').datetimepicker({
            format: 'L'
        });
        $('#tripTime').datetimepicker({
            format: 'LT'
        });
        $('table').tablesorter({
            theme : "bootstrap",
            widgets : [ "filter" ],
            widgetOptions : {
                // extra css class name (string or array) added to the filter element (input or select)
                filter_cssFilter: [
                    'form-control',
                    'form-control',
                    'form-control',
                    'form-control',
                    'form-control',
                    'form-control'
                ]
            }
        });
    });
    $('.leave-btn').on('click', function() {
        $('input[name="trip_id"]').val($(this).attr("trip_id"));
        $('#exclude_form').submit();
    });
    $('.join-btn').on('click', function() {
        $('input[name="trip_id"]').val($(this).attr("trip_id"));
        $('#include_form').submit();
    });
</script>
@endsection