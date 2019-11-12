@modal(['id' => "assignDriverModal", 'label' => "assignDriverModalLabel", 'title' => "Assign Driver"])
    <form class="needs-validation" action="{{ route('assign.driver') }}" method="POST" id="assignDriverForm" novalidate>
        @csrf
        <input type="hidden" name="trip_id" value="">
        <input type="hidden" name="driver_id" value="">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    @selectMenu(['name' => "driver_id", 'id' => "selectDriver"])
                        @slot('options')
                            <option {{ (old("driver_id") == 0 ? "selected":"") }} value="">Driver Name</option>
                            @foreach (Auth::user()->admin->drivers as $driver)
                                <option {{ (old("driver_id") == $driver->id ? "selected":"") }} value="{{ $driver->id }}">{{ $driver->name }}</option>
                            @endforeach
                        @endslot
                    @endselectMenu
                </div>
            </div>
        </div>
    </form>
    @slot("submitButton")
        <button type="button" class="btn btn-primary" onclick="event.preventDefault();
        document.getElementById('assignDriverForm').submit();">Assign</button>
    @endslot
@endmodal
