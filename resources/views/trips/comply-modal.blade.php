@modal(['id' => "complyModal", 'label' => "complyModalLabel", 'title' => "Enter compliance code"])
    <form method="POST" action="{{ route('trip.comply', 'trip::id') }}" id="complyForm">
        @csrf
        @inputbox(['defaultVal' => '', 'type' => 'text', 'name' => 'compliance_code', 'label' => 'Compliance Code']) @endinputbox
    </form>
    @slot("submitButton")
        <button type="button" class="btn btn-primary" onclick="event.preventDefault();
        document.getElementById('complyForm').submit();">Submit</button>
    @endslot
@endmodal
