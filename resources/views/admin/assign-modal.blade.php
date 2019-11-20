@modal(['id' => "assignDriverModal", 'label' => "assignDriverModalLabel", 'title' => "Assign Driver"])
    <form class="needs-validation" action="{{ route('assign.driver') }}" method="POST" id="assignDriverForm" novalidate>
        @csrf
        <input type="hidden" name="trip_id" value="">
        <input type="hidden" name="driver_id" value="">
        <div class="row">
            <div class="col-12">
                @if (Auth::user()->admin->hasDriversThatCanFetch())
                    <div class="form-group">
                        @selectMenu(['name' => "driver_id", 'id' => "selectDriver"])
                            @slot('options')
                                <option {{ (old("driver_id") == 0 ? "selected":"") }} value="">Driver Name</option>
                                @foreach ($drivers as $driver)
                                    @if ($driver->canFetch())
                                        <option {{ (old("driver_id") == $driver->id ? "selected":"") }} value="{{ $driver->id }}">{{ $driver->name }}</option>
                                    @endif
                                @endforeach
                            @endslot
                        @endselectMenu
                    </div>
                @else
                    @if (Auth::user()->admin->hasDrivers())
                        <div class="alert alert-info" role="alert">
                            <p>You have no available drivers that can fetch.</p>
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            <p>You need to Add Driver Account before you can Assign</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </form>
    @if (Auth::user()->admin->hasDrivers())
        @slot("submitButton")
            <button type="button" class="btn btn-primary" onclick="event.preventDefault();
            document.getElementById('assignDriverForm').submit();">Assign</button>
        @endslot
    @else
        @slot("submitButton")
            <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
        @endslot
    @endif
@endmodal
