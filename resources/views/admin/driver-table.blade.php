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
            @foreach ($drivers as $driver)
                <tr>
                    <td>
                        <a href="{{ route('driver_profile', $driver->id) }}">
                            {{ $driver->name }}
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-md btn-success mr-2" id="suspend-button">Suspend</button>
                        <button class="btn btn-md btn-danger mr-2" id="ban-button">Ban</button>
                    </td>
                    <td>
                    </td>
                    <td>{{ $driver->hailedTrips() }}</td>
                    <td>{{ $driver->confirmedTrips() }}</td>
                    <td>{{ $driver->unconfirmedTrips() }}</td>
                    <td>{{ $driver->credibilityPoints() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
