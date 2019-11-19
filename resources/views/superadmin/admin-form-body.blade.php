@inputbox(['defaultVal' => $admin->first_name ?? '', 'type' => 'text', 'name' => 'first_name', 'label' => 'Admin First Name']) @endinputbox
@inputbox(['defaultVal' => $admin->middle_name ?? '', 'type' => 'text', 'name' => 'middle_name', 'label' => 'Admin Middle Name']) @endinputbox
@inputbox(['defaultVal' => $admin->last_name ?? '', 'type' => 'text', 'name' => 'last_name', 'label' => 'Admin Last Name']) @endinputbox
@inputbox(['defaultVal' => $admin->email ?? '', 'type' => 'email', 'name' => 'email', 'label' => 'Email address']) @endinputbox
@if (!$edit_mode)
    @inputbox(['defaultVal' => '', 'type' => 'password', 'name' => 'password', 'label' => 'Password']) @endinputbox
    @inputbox(['defaultVal' => '', 'type' => 'password', 'name' => 'password_confirmation', 'label' => 'Confirm Password']) @endinputbox
@endif
@inputbox(['defaultVal' => $admin->phone ?? '', 'type' => 'text', 'name' => 'phone', 'label' => 'Mobile Number']) @endinputbox
@inputbox(['defaultVal' => $admin->org_acronym ?? '', 'type' => 'text', 'name' => 'org_acronym', 'label' => 'Organization Acronym']) @endinputbox
@inputbox(['defaultVal' => $admin->org_name ?? '', 'type' => 'text', 'name' => 'org_name', 'label' => 'Organization Name']) @endinputbox

<div class="form-group row">
    <label for="birthday" class="col-md-4 col-form-label text-md-right">Birthdate</label>
    <div class="col-md-6 input-group date" id="birthday" data-target-input="nearest">
        <input
            name="birthday"
            type="text"
            value="{{ old('birthday', $admin->birthday ?? '') }}"
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
                    <option {{ (old('town_id', $admin->town_id ?? 0) == $id ? "selected":"") }} value="{{ $id }}">{{ $town }}</option>
                @endforeach
            @endslot
        @endselectMenu
    </div>
</div>
