@extends('layouts.master')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">AGrS Local Web Registration Form</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        @if (Input::get('regkey'))
                            <input type="hidden" name="regkey" value="{{ Input::get('regkey') }}">
                        @endif

                        <div class="row form-group">
                            <label for="id_number" class="col-md-4 col-form-label text-md-right">Employee ID Number:</label>

                            <div class="col-md-6">
                                <input id="id_number" type="text" class="form-control{{ $errors->has('id_number') ? ' is-invalid' : '' }}" name="id_number" value="{{ old('id_number') }}" placeholder="ID Number" required autofocus>

                                @if ($errors->has('id_number'))
                                    <div class="invalid-feedback">{{ $errors->first('id_number') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name/Nickname:</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="How would you like to be addressed?" required autofocus>

                                @if ($errors->has('name'))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Gbox Email:</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="someone@gbox.adnu.edu.ph" required autofocus>

                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Username:</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="You username when logging in." required autofocus>

                                @if ($errors->has('username'))
                                    <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password:</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password:</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
