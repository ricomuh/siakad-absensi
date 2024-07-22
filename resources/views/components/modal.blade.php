@props([
    'name',
])

<div class="modal fade" id="{{ $name }}" tabindex="-1" aria-labelledby="{{ $name }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ $slot }}
        </div>
    </div>
</div>
