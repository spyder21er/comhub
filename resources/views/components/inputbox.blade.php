<div class="form-group row">
    @if ($label)
        <label for="{{ $name }}" class="col-md-4 col-form-label text-md-right">{{ $label }}</label>
    @endif
    <div class="col-md-6">
        <input id="{{ $name }}" type="{{ $type }}" class="form-control @error($name) is-invalid @enderror" name="{{ $name }}" value="{{ old($name, $defaultVal) }}" autocomplete="{{ $name }}" autofocus placeholder="{{ $label }}">
        {{ $slot }}
        @error($name)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
