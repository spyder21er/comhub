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
                                                    Join
                                                </button>
                                            </td>
                                            @endif
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6">
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#newTripModal">
                                                    New Trip
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
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
<modal id="newTripModal" label="newTripModalLabel" title="Hail new trip">
    <form action="{{ route('createTrip') }}" method="POST" id="createNewTripForm">
        @csrf
        <div class="row">
            <div class="col-6">
                <select-menu name="origin" id="selectOrigin">
                    @slot('options')
                        <option selected value="">Origin</option>
                        @include('passenger.town-options')
                    @endslot
                </select-menu>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <select-menu name="destination" id="selectDestination">
                        @slot('options')
                            <option selected value="">Destination</option>
                            @include('passenger.town-options')
                        @endslot
                    </select-menu>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <div class="input-group date" id="tripTime" data-target-input="nearest">
                        <input name="departure_time" type="text" placeholder="Select Time" class="form-control datetimepicker-input" data-target="#tripTime" />
                        <div class="input-group-append" data-target="#tripTime" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <select name="passenger_count" class="form-control" id="selectCount">
                        <option selected value="">With how many?</option>
                        <option value="0">Only me</option>
                        @for ($i = 1; $i < 15; $i++) 
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="form-check">
            <input class="form-check-input" name="exclusive" type="checkbox" id="checkExclusive">
            <label class="form-check-label" for="checkExclusive">
                Exclusive?
            </label>
        </div>
    </form>
    <slot name="submitButton">
    <button type="button" class="btn btn-primary" onclick="event.preventDefault();
    document.getElementById('createNewTripForm').submit();">Submit</button>
    </slot>
</modal>
@endsection

@section('page-scripts')
<script src="{{ asset('js/moment.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('#tripdate').datetimepicker({
            format: 'L'
        });
    });
</script>
<script type="text/javascript">
    $(function() {
        $('#tripTime').datetimepicker({
            format: 'LT'
        });
    });
</script>
@endsection