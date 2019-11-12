@modal(['id' => "suspendModal", 'label' => "suspendModalLabel", 'title' => "Assign Driver"])
    <form class="needs-validation" action="{{ route('suspend.driver') }}" method="POST" id="suspendForm" novalidate>
        @csrf
        <input type="hidden" name="driver_id" value="">
        <div class="row">
            <div class="col-12">
                <div class="form-inline">
                    <div class="form-group mx-2">
                        <input id="duration" type="text" class="form-control @error("duration") is-invalid @enderror" name="duration" value="{{ old("duration") }}" autocomplete="duration" autofocus placeholder="Duration">
                        @error("duration")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mx-2">
                        @selectMenu(['name' => "duration_units", 'id' => "duration_units"])
                            @slot('options')
                                <option {{ (old("duration_units") == "default" ? "selected":"") }} value="default">Duration</option>
                                <option {{ (old("duration_units") == "day" ? "selected":"") }} value="day">Day(s)</option>
                                <option {{ (old("duration_units") == "month" ? "selected":"") }} value="month">Month(s)</option>
                            @endslot
                        @endselectMenu
                    </div>
                </div>
            </div>
        </div>
    </form>
    @slot("submitButton")
        <button type="button" class="btn btn-primary" onclick="event.preventDefault();
        document.getElementById('suspendForm').submit();">Suspend</button>
    @endslot
@endmodal
