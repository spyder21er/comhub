<form action="{{ route('trip.excludeUser') }}" method="post" id="exclude_form">
    @csrf
    <input type="hidden" name="trip_id" value="">
</form>