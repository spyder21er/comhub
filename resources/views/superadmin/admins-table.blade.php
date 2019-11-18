<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Organization Acronym</th>
                <th>Organization Name</th>
                <th>Drivers</th>
                <th>Account Status</th>
                <th>Command</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->phone }}</td>
                    <td>{{ $admin->org_acronym }}</td>
                    <td>{{ $admin->org_name }}</td>
                    <td>{{ $admin->drivers_count }}</td>
                    <td>{{ $admin->account_status }}</td>
                    <td>
                        <button class="btn btn-{{ $admin->button_style }} btn-sm">
                            {{ $admin->change_status_command }}
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
