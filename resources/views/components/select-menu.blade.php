<div class="form-group">
    <select name="{{ $name }}" class="custom-select @error($name) is-invalid @enderror" id="{{ $id }}">
        {{ $options }}
    </select>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>