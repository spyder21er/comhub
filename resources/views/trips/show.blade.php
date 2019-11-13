@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h3>Trip Information</h3></div>
                <div class="card-body">
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
                                    <th>User ID</th>
                                    <th>Status</th>
                                    <th>Passenger comment</th>
                                    <th>Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trip->passengers as $passenger)
                                    <tr>
                                        <td>{{ $passenger->id }} </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
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
@endsection