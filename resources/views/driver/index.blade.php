@extends('layouts.app')

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
                        <div class="tab-pane fade show active" id="trips" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Trip No.</th>
                                            <th scope="col">Origin</th>
                                            <th scope="col">Destination</th>
                                            <th scope="col">Departure Time</th>
                                            <th scope="col">Passengers</th>
                                            @if(Auth::user()->role->id !== 1)
                                                <th scope="col">Commands</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Naga</td>
                                            <td>Pasacao</td>
                                            <td>10pm</td>
                                            <td>5</td>
                                            @if(Auth::user()->role->id !== 1)
                                            <td>
                                                <button class="btn btn-sm btn-success" type="button">
                                                    Fetch
                                                </button>
                                            </td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="history" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-stripped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Departure Time</th>
                                            <th scope="col">Trip code</th>
                                            <th scope="col">Origin</th>
                                            <th scope="col">Destination</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>09-02-19</td>
                                            <td>10:00 PM</td>
                                            <td>NP19-0354</td>
                                            <td>Naga</td>
                                            <td>Pasacao</td>
                                            <td>Complied</td>
                                        </tr>
                                        <tr>
                                            <td>09-03-19</td>
                                            <td>10:00 PM</td>
                                            <td>NP19-0427</td>
                                            <td>Naga</td>
                                            <td>Pasacao</td>
                                            <td>Missed/Unconfirmed compliance code</td>
                                        </tr>
                                        <tr>
                                            <td>09-04-19</td>
                                            <td>10:00 PM</td>
                                            <td>NP19-0723</td>
                                            <td>Naga</td>
                                            <td>Pasacao</td>
                                            <td>Cancelled</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection