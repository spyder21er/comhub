<div class="tab-pane fade show active" id="trips" role="tabpanel">
    <div class="table-responsive">
        <table class="table table-bordered table-striped tablesorter">
            <thead>
                <tr>
                    <th class="sorter-false filter-false" scope="col">Command</th>
                    <th scope="col">Driver</th>
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
                        @if (Auth::user()->isPassenger() || Auth::user()->isDriver())
                            <td>
                                @if (Auth::user()->hasTripToday())
                                    @if ($my_trips->contains($trip))
                                        <button tripId="{{ $trip->id }}" class="btn btn-sm btn-danger leave-btn" type="button">
                                            {{ Auth::user()->leaveButtonName() }}
                                        </button>
                                    @endif
                                @else
                                    <button
                                        tripId="{{ $trip->id }}"
                                        class="btn btn-sm btn-success join-btn"
                                        type="button"
                                        {{ ($trip->hasDriver() && Auth::user()->isDriver()) ? 'disabled' : '' }}
                                    >
                                        {{ Auth::user()->joinButtonName() }}
                                    </button>
                                @endif
                            </td>
                        @endif
                        <td>{{ ($trip->driver->name) ?? '' }}</td>
                        <td>{{ $trip->code }} </td>
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
                    <td colspan="7">
                        @if(Auth::user()->isPassenger() && !Auth::user()->hasTripToday())
                            <button type="button" class="btn btn-info mb-3 text-white" data-toggle="modal" data-target="#newTripModal">
                                Create New Trip
                            </button>
                        @endif
                    </td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
