<x-main-layout>
    @section('title', 'Dashboard')
    <!-- Your logged in page using bootstrap -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Logged In</div>
                    <div class="card-body">
                        <p>Welcome to your logged in page!</p>
                        <a href="#" class="btn btn-primary">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>