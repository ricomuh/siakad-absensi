@if (session()->has('message'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('message') }}
    <!-- close button -->
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <!-- close icon -->
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif