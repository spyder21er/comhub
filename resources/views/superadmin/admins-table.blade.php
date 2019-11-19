<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th class="filter-false">Command</th>
                <th class="filter-select filter-exact">Account Status</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Organization Acronym</th>
                <th class="filter-select filter-exact">Hometown</th>
                <th class="filter-false">Drivers</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
                <tr>
                    <td>
                        <a href="{{ route('edit.admin', $admin->id) }}" class="btn btn-primary btn-sm btn-edit">
                            Edit
                        </a>
                        <button admin_id="{{ $admin->id }}" class="btn btn-{{ $admin->button_style }} btn-sm btn-change">
                            {{ $admin->change_status_command }}
                        </button>
                    </td>
                    <td>{{ $admin->account_status }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->phone }}</td>
                    <td>{{ $admin->org_acronym }}</td>
                    <td>{{ $admin->town_name }}</td>
                    <td>{{ $admin->drivers_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
