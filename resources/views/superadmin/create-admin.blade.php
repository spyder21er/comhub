<h2 class="mt-4 mb-4 text-center">Create new admin account</h2>
<form method="POST" action="{{ route('register.admin') }}">
    @csrf

    @include('superadmin.admin-form-body')

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                Register new admin
            </button>
        </div>
    </div>
</form>
