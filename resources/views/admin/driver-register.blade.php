<div class="card">
    <div class="card-header">Register new driver</div>

    <div class="card-body">
        <form method="POST" action="{{ route('register.driver') }}">
            @csrf

            @inputbox(['defaultVal' => $driver->first_name ?? '', 'type' => 'text', 'name' => 'first_name', 'label' => 'Driver First Name']) @endinputbox
            @inputbox(['defaultVal' => $driver->middle_name ?? '', 'type' => 'text', 'name' => 'middle_name', 'label' => 'Driver Middle Name']) @endinputbox
            @inputbox(['defaultVal' => $driver->last_name ?? '', 'type' => 'text', 'name' => 'last_name', 'label' => 'Driver Last Name']) @endinputbox
            @inputbox(['defaultVal' => $driver->email ?? '', 'type' => 'email', 'name' => 'email', 'label' => 'Email address']) @endinputbox
            @inputbox(['defaultVal' => '', 'type' => 'password', 'name' => 'password', 'label' => 'Password']) @endinputbox
            @inputbox(['defaultVal' => '', 'type' => 'password', 'name' => 'password_confirmation', 'label' => 'Confirm Password']) @endinputbox
            @inputbox(['defaultVal' => $driver->phone ?? '', 'type' => 'text', 'name' => 'phone', 'label' => 'Mobile Number']) @endinputbox
            @inputbox(['defaultVal' => $driver->plate_number ?? '', 'type' => 'text', 'name' => 'plate_number', 'label' => 'Vehicle Plate Number']) @endinputbox
            @inputbox(['defaultVal' => $driver->license_number ?? '', 'type' => 'text', 'name' => 'license_number', 'label' => 'License Number']) @endinputbox

            <div class="form-group row">
                <label for="license_expiry" class="col-md-4 col-form-label text-md-right">License expiry date</label>
                <div class="col-md-6 input-group date" id="license_expiry" data-target-input="nearest">
                    <input
                        name="license_expiry"
                        type="text"
                        value="{{ old('license_expiry') }}"
                        placeholder="License expiry date"
                        class="form-control datetimepicker-input @error('license_expiry')is-invalid @enderror"
                        data-target="#license_expiry" />
                    <div class="input-group-append" data-target="#license_expiry" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar-o"></i></div>
                    </div>
                    @error('license_expiry')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="birthday" class="col-md-4 col-form-label text-md-right">Birthdate</label>
                <div class="col-md-6 input-group date" id="birthday" data-target-input="nearest">
                    <input
                        name="birthday"
                        type="text"
                        value="{{ old('birthday') }}"
                        placeholder="Birthdate"
                        class="form-control datetimepicker-input @error('birthday')is-invalid @enderror"
                        data-target="#birthday" />
                    <div class="input-group-append" data-target="#birthday" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar-o"></i></div>
                    </div>
                    @error('birthday')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Register new driver
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
