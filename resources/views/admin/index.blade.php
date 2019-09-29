@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#passengers-tab">Passengers Activity</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#drivers-tab">Drivers Activity</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#accounts-tab">Manage Accounts</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="passengers-tab" role="tabpanel">
                                    Passenger content
                                </div>
                                <div class="tab-pane fade" id="drivers-tab" role="tabpanel">
                                    Driver content
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