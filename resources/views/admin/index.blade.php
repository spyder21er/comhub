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
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-controls="drivers-tab" aria-selected="false" role="tab" data-toggle="tab" href="#drivers-tab">Drivers Activity</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-controls="accounts-tab" aria-selected="false" role="tab" data-toggle="tab" href="#accounts-tab">Add Driver Account</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="drivers-tab" role="tabpanel">
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
@endsection

@section('page-scripts')
    <script src="{{ asset('js/bootstrap-tablesorter.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-tablesorter.widgets.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(function() {
            $('table').tablesorter({
                theme : "bootstrap",
            });
        });
        $('#birthday').datetimepicker({
            format: 'L'
        });
    </script>
@endsection
