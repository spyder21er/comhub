@extends('layouts.master')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">AGrS Login</div>
                <div class="card-body">
                    <form method="POST" action="">
                        @csrf

                        <div class="row form-group">
                            <label for="id_number" class="col-md-4 col-form-label">Username</label>

                            <div class="col-md-8">
                                <input id="id_number" type="text" class="form-control{{ $errors->has('id_number') ? ' is-invalid' : '' }}" name="id_number" value="{{ old('id_number') }}" required autofocus>

                                @if ($errors->has('id_number'))
                                    <div class="invalid-feedback">{{ $errors->first('id_number') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="password" class="col-md-4 col-form-label">Password</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-8 ml-auto">
                                <button type="submit" class="btn btn-primary">Login</button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
