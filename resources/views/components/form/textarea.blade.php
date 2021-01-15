@php
    $isInvalid = $errors->has($name) ? ' is-invalid' : null;
@endphp
<div class="form-group">
    {{ Form::label($name, $labelValue) }}
    {{ Form::textarea($name, $value, array_merge(['class' => "form-control {$isInvalid}"], $attributes)) }}
    @error($name)
        <div class="invalid-feedback">{{ $message }} </div>
    @enderror
</div>
