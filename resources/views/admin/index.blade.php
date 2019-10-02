@extends('layouts.app')

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
                        <div class="col-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search...">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-controls="passengers-tab" aria-selected="true" role="tab" data-toggle="tab" href="#passengers-tab">Passengers Activity</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-controls="drivers-tab" aria-selected="false" role="tab" data-toggle="tab" href="#drivers-tab">Drivers Activity</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-controls="accounts-tab" aria-selected="false" role="tab" data-toggle="tab" href="#accounts-tab">Add Driver Account</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="passengers-tab" role="tabpanel">
                                    @include('admin.pass-table')
                                </div>
                                <div class="tab-pane fade" id="drivers-tab" role="tabpanel">
                                    @include('admin.driver-table')
                                </div>
                                <div class="tab-pane fade" id="accounts-tab" role="tabpanel">
                                    Accounts content
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