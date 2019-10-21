<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Total trips hailed</th>
                <th>Confirmed trips</th>
                <th>Unconfirmed trips</th>
                <th>Credibility points</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($drivers as $driver)
                <tr>
                    <td>{{ $driver->name }}</td>
                    <td>{{ $driver->hailedTrips() }}</td>
                    <td>{{ $driver->confirmedTrips() }}</td>
                    <td>{{ $driver->unconfirmedTrips() }}</td>
                    <td>{{ $driver->credibilityPoints() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
