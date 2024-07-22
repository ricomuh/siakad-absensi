@if (session()->has('success'))
<div class="container">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <!-- close button -->
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <!-- close icon -->
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif

@if (session()->has('error'))
<div class="container">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <!-- close button -->
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <!-- close icon -->
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif

@push('scripts')
<script>
    // auto close the alert after 3 seconds
    $(".alert").delay(3000).slideUp(300, function() {
        $(this).alert('close');
    });
</script>
@endpush
