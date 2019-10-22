@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Driver Profile</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ asset('images/user.png') }}" alt="" class="img-thumbnail" height="200" width="200">
                        </div>
                        <div class="col-9">
                            <h4>Name: {{ $driver->name }}</h4>
                            <h4>Email: {{ $driver->email }}</h4>
                            <h4>Phone: {{ $driver->phone }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-md btn-primary" id="back-button"><< Go Back</button>
                    <button class="btn btn-md btn-warning">Suspend this driver</button>
                    <button class="btn btn-md btn-danger">Ban this driver</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-scripts')
    <script>
        $('#back-button').on('click', function() {
            history.go(-1);
        });
    </script>
@endsection
