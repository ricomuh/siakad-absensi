@props(['label', 'name', 'type' => 'text', 'value' => null, 'placeholder' => null, 'error' => null, 'slot' => null, 'class' => null, 'attributes' => []])
<div class="form-group {{ $class }}">
    <label for="{{ $name }}">{{ $label }}</label>

    @if (!$slot->isEmpty())
    {{ $slot }}
    @else
    <input type="{{ $type }}" class="form-control @if ($error) is-invalid @endif" id="{{ $name }}" name="{{ $name }}" value="{{ $value }}" placeholder="{{ $placeholder }}" @foreach ($attributes as $key=> $attribute)
    {{ $key }}="{{ $attribute }}"
    @endforeach
    >
    @endif

    @if ($error)
    <div class="invalid-feedback">
        {{ $error }}
    </div>
    @endif
</div>