<x-main-layout>
    @section('title', 'Sesi Kelas')

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-widget widget-user-2">
                    <div class="card-header">
                        <h3 class="card-title">Sesi Kelas</h3>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
