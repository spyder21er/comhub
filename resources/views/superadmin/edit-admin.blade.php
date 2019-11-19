@extends('layouts.app')

@section('page-styles')
<link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Super Admin Dashboard</h3>
                    </div>
                    <div class="card-body">
                        @include('components.flash')
                        <form action="{{ route('update.admin', $admin->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            @include('superadmin.admin-form-body')

                            <div class="form-group row mb-0">
                                <div class="col-md-6 btn-group offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                    <a class="btn btn-secondary text-white" href="{{ route('admin.super') }}">
                                        Cancel
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


@section('page-scripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $('.flash-message').delay(4000).fadeOut(1000);
        $('#birthday').datetimepicker({
            format: 'L'
        });
    </script>
@endsection
