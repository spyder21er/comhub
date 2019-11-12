<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
                <th>Status</th>
                <th>Total trips hailed</th>
                <th>Confirmed trips</th>
                <th>Unconfirmed trips</th>
                <th>Credibility points</th>
            </tr>
        </thead>
        <tbody>
            @if (!is_null($drivers))
                @foreach ($drivers as $driver)
                    <tr>
                        <td>
                            <a href="{{ route('driver_profile', $driver->id) }}">
                                {{ $driver->name }}
                            </a>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                @if ($driver->isBanned() || $driver->isSuspended())
                                    <button driverId="{{ $driver->id }}" type="button" class="btn btn-md btn-primary mr-2 liftPenalty-btn">
                                        {{ $driver->isBanned() ? "Unban" : "Lift Suspension" }}
                                    </button>
                                @else
                                    <button driverId="{{ $driver->id }}" type="button" class="btn btn-md btn-success mr-2 suspend-btn" data-toggle="modal" data-target="#suspendModal">
                                        Suspend
                                    </button>
                                    <button driverId="{{ $driver->id }}" type="button" class="btn btn-md btn-danger mr-2 ban-btn">Ban</button>
                                @endif
                            </div>
                        </td>
                        <td>
                            {{ $driver->status }}
                        </td>
                        <td>{{ $driver->hailedTrips() }}</td>
                        <td>{{ $driver->confirmedTrips() }}</td>
                        <td>{{ $driver->unconfirmedTrips() }}</td>
                        <td>{{ $driver->credibilityPoints() }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
