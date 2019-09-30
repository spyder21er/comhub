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
                                            <th scope="col">Commands</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Naga</td>
                                            <td>Pasacao</td>
                                            <td>10pm</td>
                                            <td>5</td>
                                            <td>
                                                <button class="btn btn-sm btn-success" type="button">
                                                    Join
                                                </button>
                                            </td>
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
<div class="modal fade" id="newTripModal" tabindex="-1" role="dialog" aria-labelledby="newTripModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newTripModalLabel">Hail new trip</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('createTrip') }}" method="POST" id="createNewTripForm">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <select name="origin" class="form-control" id="selectOrigin">
                                    <option selected value="">Origin</option>
                                    <option>Naga</option>
                                    <option>Pasacao</option>
                                    <option>Milaor</option>
                                    <option>San Fernando</option>
                                    <option>Calabanga</option>
                                    <option>San Fernando</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="destination" class="form-control" id="selectDestination">
                                    <option selected value="">Destination</option>
                                    <option>Naga</option>
                                    <option>Pasacao</option>
                                    <option>Milaor</option>
                                    <option>San Fernando</option>
                                    <option>Calabanga</option>
                                    <option>San Fernando</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <div class="input-group date" id="tripTime" data-target-input="nearest">
                                    <input name="time" type="text" placeholder="Select Time" class="form-control datetimepicker-input" data-target="#tripTime" />
                                    <div class="input-group-append" data-target="#tripTime" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="count" class="form-control" id="selectCount">
                                    <option selected value="">With how many?</option>
                                    <option>Only me</option>
                                    @for ($i = 2; $i <= 15; $i++) <option value="{{ $i }}">{{ $i }}</option>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="event.preventDefault();
                    document.getElementById('createNewTripForm').submit();">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
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