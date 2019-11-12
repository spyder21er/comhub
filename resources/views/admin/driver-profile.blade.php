@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>Driver Profile</h3></div>
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col-3">
                            <img src="{{ asset('images/user.png') }}" alt="" class="img-thumbnail" height="200" width="200">
                        </div>
                        <div class="col-9">
                            <h2>Name: {{ $driver->name }}</h2>
                            <h4>Organization: {{ $driver->organization }}</h4>
                            <h4>Email: {{ $driver->email }}</h4>
                            <h4>Phone: {{ $driver->phone }}</h4>
                            <h4>Vehicle Plate Number: {{ $driver->plate_number }}</h4>
                        </div>
                    </div>
                    <div><h4>Trip History</h4></div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Trip code</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($driver->trips()->latest()->get() as $trip)
                                    <tr>
                                        <td>{{ $trip->created_at }} </td>
                                        <td>{{ $trip->departure_time }}</td>
                                        <td>{{ $trip->code }}</td>
                                        <td>{{ $trip->origin->name }}</td>
                                        <td>{{ $trip->destination->name }}</td>
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

@section('page-scripts')
    <script>
        $('#back-button').on('click', function() {
            history.back();
        });
        $('#suspend-button').on('click', function() {
            alert('suspend');
        });
        $('#ban-button').on('click', function() {
            alert('ban');
        });
    </script>
@endsection
