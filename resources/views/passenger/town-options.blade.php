@foreach ($towns as $id => $town)
    <option {{ (old($name) == $id ? "selected":"") }} value="{{ $id }}">{{ $town }}</option>
@endforeach