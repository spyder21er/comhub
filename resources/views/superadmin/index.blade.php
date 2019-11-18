@extends('layouts.app')

@section('page-styles')
<link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Super Admin Dashboard</h3>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" aria-controls="trips-tab" aria-selected="true" role="tab" data-toggle="tab" href="#admin-tab">Registered Admins</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-controls="drivers-tab" aria-selected="false" role="tab" data-toggle="tab" href="#create-admin-tab">Create New Admin</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="admin-tab" role="tabpanel">
                                @include('superadmin.admins-table')
                            </div>
                            <div class="tab-pane fade" id="create-admin-tab" role="tabpanel">
                                @include('superadmin.create-admin')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('page-scripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $('#birthday').datetimepicker({
            format: 'L'
        });
    </script>
@endsection
