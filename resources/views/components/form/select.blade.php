<div class="form-group">
    @if ($hasLabel)
    {{ Form::label($name, $labelValue) }}
    @endif
    {{ Form::select($name, $value->mapWithKeys(fn($item) => [$item['id'] => $item['name']]), $selected, array_merge(["class" => "form-control"], $attributes,)) }}
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
