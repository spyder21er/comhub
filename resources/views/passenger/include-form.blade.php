<form action="{{ route('trip.includeUser') }}" method="post" id="include_form">
    @csrf
    <input type="hidden" name="trip_id" value="">
</form>