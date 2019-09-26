@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Hail</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#newTripModal">
                        New Trip
                    </button>
                    
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
                                    <div class="form-group">
                                        <select class="form-control" id="selectOrigin">
                                            <option selected value="">Origin</option>
                                            <option>Naga</option>
                                            <option>Pasacao</option>
                                            <option>Milaor</option>
                                            <option>San Fernando</option>
                                            <option>Calabanga</option>
                                            <option>San Fernando</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" id="selectDestination">
                                            <option selected value="">Destination</option>
                                            <option>Naga</option>
                                            <option>Pasacao</option>
                                            <option>Milaor</option>
                                            <option>San Fernando</option>
                                            <option>Calabanga</option>
                                            <option>San Fernando</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" id="selectTime">
                                            <option selected value="">Time</option>
                                            @foreach (['AM', 'PM'] as $AMPM)
                                                @for ($i = 12; $i < 24; ++$i)
                                                    @if($i = 12)
                                                        <option value="{{ $i }}{{ $AMPM }}">{{ $i }} {{ $AMPM }}</option>
                                                    @endif
                                                        <option value="{{ $i % 12 }}{{ $AMPM }}">{{ $i % 12 }} {{ $AMPM }}</option>
                                                @endfor
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
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
                </table>
            </div>
        </div>
    </div>
</div>
@endsection