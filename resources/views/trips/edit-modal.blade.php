@modal(['id' => "editCommentModal", 'label' => "editCommentModalLabel", 'title' => "Add/Edit Comment"])
    <form method="POST" action="{{ route('trip.comment', $trip->id) }}" id="createCommentForm">
        @csrf
        <div class="form-group">
            <label for="passenger_comment">Comment:</label>
            <textarea name="passenger_comment" class="form-control" id="passenger_comment" rows="9"></textarea>
        </div>
    </form>
    @slot("submitButton")
        <button type="button" class="btn btn-primary" onclick="event.preventDefault();
        document.getElementById('createCommentForm').submit();">Save</button>
    @endslot
@endmodal
