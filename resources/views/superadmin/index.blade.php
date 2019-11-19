@extends('layouts.app')

@section('page-styles')
<link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap-tablesorter.css') }}" rel="stylesheet">
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
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link {{ ($errors->any() ? '' : 'active') }}" aria-controls="trips-tab" aria-selected="true" role="tab" data-toggle="tab" href="#admin-tab">Registered Admins</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ($errors->any() ? 'active' : '') }}" aria-controls="drivers-tab" aria-selected="false" role="tab" data-toggle="tab" href="#create-admin-tab">Create New Admin</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade {{ ($errors->any() ? '' : 'show active') }}" id="admin-tab" role="tabpanel">
                                @include('superadmin.admins-table')
                            </div>
                            <div class="tab-pane fade {{ ($errors->any() ? 'show active' : '') }}" id="create-admin-tab" role="tabpanel">
                                @include('superadmin.create-admin')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('page-scripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-tablesorter.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-tablesorter.widgets.js') }}"></script>
    <script>
        $('#birthday').datetimepicker({
            format: 'L'
        });
        $('table').tablesorter({
            theme : "bootstrap",
            widgets : ["filter"],
            widgetOptions : {
                filter_cssFilter : 'form-control'
            }
        });
        $('.btn-change').on('click', function() {
            let route = "{{ route('change.admin.status', ':id') }}";
            route = route.replace(':id', $(this).attr('admin_id'));
            let btn = $(this);
            let status = btn.parent().prev();
            $.ajax({
                url : route,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                }
            })
            .done(function(data) {
                btn.html(data.change_status_command);
                btn.removeClass('btn-primary');
                btn.removeClass('btn-danger');
                btn.addClass('btn-'+data.button_style);
                status.html(data.account_status);
            })
            .fail(function(e) {
                console.log(e)
            })
        });
    </script>
@endsection
