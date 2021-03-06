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
                @foreach ($my_trips as $trip)
                    @if ($trip->isNotToday())
                        <tr>
                            <td>{{ $trip->created_at }} </td>
                            <td>{{ $trip->departure_time }}</td>
                            <td>{!! $trip->link !!}</td>
                            <td>{{ $trip->origin->name }}</td>
                            <td>{{ $trip->destination->name }}</td>
                            <td>
                                @if (Auth::user()->complied($trip))
                                    Complied
                                @else
                                    Not confirmed
                                    @if (Auth::user()->joined($trip))
                                        <button type="button" class="btn btn-sm btn-primary btn-comply" id="{{ $trip->id }}">
                                            <i class="fa fa-pencil"></i>
                                            comply
                                        </button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
