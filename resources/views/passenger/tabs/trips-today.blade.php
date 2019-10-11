<div class="tab-pane fade show active" id="trips" role="tabpanel">
    <div class="table-responsive">
        <table class="table table-bordered table-striped tablesorter">
            <thead>
                <tr>
                    @if (Auth::user()->isPassenger())
                        <th class="sorter-false filter-false">Command</th>
                    @endif
                    <th scope="col">Trip Code</th>
                    <th class="filter-select filter-exact" scope="col">Origin</th>
                    <th class="filter-select filter-exact" scope="col">Destination</th>
                    <th class="filter-false" scope="col">Departure Time</th>
                    <th class="filter-false" scope="col">Passengers</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trips as $trip)
                    <tr>
                        @if (Auth::user()->isPassenger())
                            <td>
                                @if (Auth::user()->hasTripToday())
                                    @if ($my_trips->contains($trip))
                                        <button class="btn btn-sm btn-danger" type="button">
                                            Leave
                                        </button>
                                    @endif
                                @else
                                    <button class="btn btn-sm btn-success" type="button">
                                        Join
                                    </button>
                                @endif
                            </td>
                        @endif
                        <td>{{ $trip->code }}</td>
                        <td>{{ $trip->origin->name }}</td>
                        <td>{{ $trip->destination->name }}</td>
                        <td>{{ $trip->departure_time }}</td>
                        <td>{{ $trip->passengerCount() }}/{{ $trip->max_passenger() }}</td>
                    </tr>
                @endforeach
            </tbody>
            @if(Auth::user()->isPassenger())
            <tfoot>
                <tr>
                    <td colspan="6">
                        <button type="button" class="btn btn-info text-white" data-toggle="modal" data-target="#newTripModal">
                            Create New Trip
                        </button>
                    </td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>