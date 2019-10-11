<modal id="newTripModal" label="newTripModalLabel" title="Hail new trip">
    <form action="{{ route('createTrip') }}" method="POST" id="createNewTripForm">
        @csrf
        <div class="row">
            <div class="col-6">
                <select-menu name="origin_id" id="selectOrigin">
                    @slot('options')
                        <option {{ (old("origin_id") == 0 ? "selected":"") }} value="">Origin</option>
                        @include('passenger.town-options', ['name' => 'origin_id'])
                    @endslot
                </select-menu>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <select-menu name="destination_id" id="selectDestination">
                        @slot('options')
                            <option {{ (old("destination_id") == 0 ? "selected":"") }} value="">Destination</option>
                            @include('passenger.town-options', ['name' => 'destination_id'])
                        @endslot
                    </select-menu>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <div class="input-group date" id="tripTime" data-target-input="nearest">
                        <input 
                            name="departure_time" 
                            type="text" 
                            value="{{ old('departure_time') }}"
                            placeholder="Select Time" 
                            class="form-control datetimepicker-input @error('departure_time')is-invalid @enderror" 
                            data-target="#tripTime" />
                        <div class="input-group-append" data-target="#tripTime" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                        </div>
                        @error('departure_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <select-menu name="guest_count" id="selectCount">
                        @slot('options')
                            <option {{ (old("guest_count") == 0 ? "selected":"") }} value="">With how many?</option>
                            <option {{ (old("guest_count") == 1 ? "selected":"") }} value="1">Only me</option>
                            @for ($i = 2; $i <= 15; $i++)
                                <option {{ (old("guest_count") == $i ? "selected":"") }} value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        @endslot
                    </select-menu>
                </div>
            </div>
        </div>
        <div class="form-check">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="Public" name="exclusive" value="false" class="custom-control-input" checked>
                <label class="custom-control-label" for="Public">For public</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="exclusive" name="exclusive" value="true" class="custom-control-input">
                <label class="custom-control-label" for="exclusive">Exclusive</label>
            </div>
        </div>
    </form>
    <slot name="submitButton">
        <button type="button" class="btn btn-primary" onclick="event.preventDefault();
        document.getElementById('createNewTripForm').submit();">Submit</button>
    </slot>
</modal>