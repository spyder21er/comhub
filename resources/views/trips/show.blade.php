@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h3>Trip Information</h3></div>
                <div class="card-body">
                    @include('components.flash')
                    <div class="row mb-5">
                        <div class="col-3">
                            <img src="{{ asset('images/user.png') }}" alt="" class="img-thumbnail" height="200" width="200">
                        </div>
                        <div class="col-9">
                            <h2>Trip code: {{ $trip->code }}</h2>
                            <h4>Time: {{ $trip->departure_time }}</h4>
                            <h4>Date: {{ $trip->created_at }}</h4>
                            <h4>Driver: {{ ($trip->driver->name) ?? '' }}</h4>
                            <h4>Origin: {{ $trip->origin->name }}</h4>
                            <h4>Destination: {{ $trip->destination->name }}</h4>
                            <h4>Registered Passengers: {{ $trip->passengers()->count() }}</h4>
                            <h4>Guest Passengers: {{ $trip->guest_count }}</h4>
                        </div>
                    </div>
                    <div><h4>Passengers</h4></div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Passenger</th>
                                    <th>Compliance</th>
                                    <th>Passenger comment</th>
                                    <th>Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trip->passengers as $passenger)
                                    <tr>
                                        <td>
                                            {{ $passenger->first_name }}
                                        </td>
                                        <td>
                                            @if ($passenger->complied($trip->id))
                                                Complied
                                            @else
                                                Not confirmed
                                                @if ($passenger->id == Auth::user()->id)
                                                <button type="button" class="btn btn-sm btn-primary btn-comply" >
                                                    <i class="fa fa-pencil"></i>
                                                    comply
                                                </button>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <span>
                                                {{ $passenger->pivot->passenger_comment }}
                                            </span>

                                            @if ($passenger->id == Auth::user()->id)
                                            <button type="button" class="btn btn-sm btn-primary btn-edit">
                                                <i class="fa fa-pencil"></i>
                                                edit
                                            </button>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $passenger->pivot->passenger_rating }}
                                            @if ($passenger->id == Auth::user()->id && !$passenger->pivot->passenger_rating)
                                            <button type="button" class="btn btn-sm btn-primary btn-rate" data-toggle="modal" data-target="#rateModal">
                                                <i class="fa fa-star"></i>
                                                rate
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if (Auth::user()->joined($trip->id))
    @include('trips.edit-modal')
    @include('trips.comply-modal')
    @include('trips.rate-modal')
@endif
@endsection

@if (Auth::user()->joined($trip->id))
    @section('page-scripts')
        <script>
            $('.flash-message').delay(4000).fadeOut(1000);
            $('.btn-comply').on('click', function () {
                $('#complyModal').modal('show');
            });
            $('.btn-edit').on('click', function () {
                $('#passenger_comment').val($(this).prev().text().trim());
                $('#editCommentModal').modal('show');
            });
        </script>
    @endsection
@endif
