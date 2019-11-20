@modal(['id' => "rateModal", 'label' => "rateModalLabel", 'title' => "Rate"])
    <form method="POST" action="{{ route('trip.rate', $trip->id) }}" id="rateForm">
        @csrf
        <div class="form-group">
            <label for="passenger_rating">Rating:</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="passenger_rating" id="inlineRadio1" value="1">
                <label class="form-check-label" for="inlineRadio1">1</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="passenger_rating" id="inlineRadio2" value="2">
                <label class="form-check-label" for="inlineRadio2">2</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="passenger_rating" id="inlineRadio3" value="3">
                <label class="form-check-label" for="inlineRadio3">3</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="passenger_rating" id="inlineRadio4" value="4">
                <label class="form-check-label" for="inlineRadio4">4</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="passenger_rating" id="inlineRadio5" value="5">
                <label class="form-check-label" for="inlineRadio5">5</label>
            </div>
        </div>
    </form>
    @slot("submitButton")
        <button type="button" class="btn btn-primary" onclick="event.preventDefault();
        document.getElementById('rateForm').submit();">Save</button>
    @endslot
@endmodal
