@extends('layouts.app')

@section('page-styles')
<link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap-tablesorter.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9">
                            <h3>Admin Dashboard</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @include('components.default-alert')
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-controls="trips-tab" aria-selected="true" role="tab" data-toggle="tab" href="#trips-tab">Trips Today</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-controls="drivers-tab" aria-selected="false" role="tab" data-toggle="tab" href="#drivers-tab">Drivers Activity</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-controls="accounts-tab" aria-selected="false" role="tab" data-toggle="tab" href="#accounts-tab">Add Driver Account</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="trips-tab" role="tabpanel">
                                    @include('admin.trips-today')
                                </div>
                                <div class="tab-pane fade" id="drivers-tab" role="tabpanel">
                                    @include('admin.driver-table')
                                </div>
                                <div class="tab-pane fade" id="accounts-tab" role="tabpanel">
                                    @include('admin.driver-register')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.assign-modal')
@include('admin.suspend-modal')
<form action="{{ route('ban.driver') }}" id="banForm" class="needs-validation" method="POST" novalidate>
    @csrf
    <input type="hidden" name="driver_id" value="">
</form>
<form action="{{ route('liftPenalty.driver') }}" id="liftPenaltyForm" class="needs-validation" method="POST" novalidate>
    @csrf
    <input type="hidden" name="driver_id" value="">
</form>
@endsection

@section('page-scripts')
    <script src="{{ asset('js/bootstrap-tablesorter.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-tablesorter.widgets.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $('table').tablesorter({
            theme : "bootstrap",
        });
        $('#birthday').datetimepicker({
            format: 'L'
        });
        $('.assign-btn').on('click', function() {
            $('input[name="trip_id"]').val($(this).attr("tripId"));
        });
        $('#selectDriver').on('change', function() {
            $('input[name="driver_id"]').val($(this).val());
        });
        $('.suspend-btn').on('click', function() {
            $('input[name="driver_id"]').val($(this).attr("driverId"));
        });
        $('.ban-btn').on('click', function() {
            $('input[name="driver_id"]').val($(this).attr("driverId"));
            $('#banForm').submit();
        });
        $('.liftPenalty-btn').on('click', function() {
            $('input[name="driver_id"]').val($(this).attr("driverId"));
            $('#liftPenaltyForm').submit();
        });
    </script>
@endsection
