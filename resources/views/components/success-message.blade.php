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
