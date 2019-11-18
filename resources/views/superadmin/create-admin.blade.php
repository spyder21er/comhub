<h2 class="mt-4 mb-4 text-center">Create new admin account</h2>
<form method="POST" action="{{ route('register.admin') }}">
    @csrf

    @inputbox(['type' => 'text', 'name' => 'first_name', 'label' => 'Driver First Name']) @endinputbox
    @inputbox(['type' => 'text', 'name' => 'middle_name', 'label' => 'Driver Middle Name']) @endinputbox
    @inputbox(['type' => 'text', 'name' => 'last_name', 'label' => 'Driver Last Name']) @endinputbox
    @inputbox(['type' => 'email', 'name' => 'email', 'label' => 'Email address']) @endinputbox
    @inputbox(['type' => 'password', 'name' => 'password', 'label' => 'Password']) @endinputbox
    @inputbox(['type' => 'password', 'name' => 'password_confirmation', 'label' => 'Confirm Password']) @endinputbox
    @inputbox(['type' => 'text', 'name' => 'phone', 'label' => 'Mobile Number']) @endinputbox
    @inputbox(['type' => 'text', 'name' => 'org_acronym', 'label' => 'Organization Acronym']) @endinputbox
    @inputbox(['type' => 'text', 'name' => 'org_name', 'label' => 'Organization Name']) @endinputbox

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
                <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
            </div>
            @error('birthday')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="selectTown" class="col-md-4 col-form-label text-md-right">Hometown</label>
        <div class="col-md-6">
            @selectMenu(['name' => "town_id", 'id' => "selectTown"])
                @slot('options')
                    <option {{ (old("town_id") == 0 ? "selected":"") }} value="">Hometown</option>
                    @foreach ($towns as $id => $town)
                        <option {{ (old('town_id') == $id ? "selected":"") }} value="{{ $id }}">{{ $town }}</option>
                    @endforeach
                @endslot
            @endselectMenu
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                Register new admin
            </button>
        </div>
    </div>
</form>
