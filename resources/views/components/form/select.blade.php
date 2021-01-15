@php
    $isInvalid = $errors->has($name) ? ' is-invalid' : null;
@endphp
<div class="form-group">
    @if ($labelValue)
    {{ Form::label($name, $labelValue) }}
    @endif
    {{ Form::select($name,
                    $value->mapWithKeys(fn($item) => [$item['id'] => $item['name']]),
                    $selected,
                    array_merge(["class" => "form-control {$isInvalid}"], $attributes))
    }}
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>



