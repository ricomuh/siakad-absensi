@props(['schedules'])
@php
$colors = [
    'bg-light',
    'bg-primary',
    'bg-secondary',
    'bg-success',
    'bg-danger',
    'bg-warning',
    'bg-info',
    'bg-dark',
];
@endphp
<section class="content pb-3">
    <div class="container-fluid">
        <div class="row five-cards-per-row">
            @foreach ($schedules as $day => $daySchedule)
            <div class="col-6 col-md mb-3"> <!-- Adjusted for 5 cards per row -->
                <div class="card {{ $colors[$loop->iteration] }}">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ ucfirst($day) }}
                        </h3>
                    </div>
                    <div class="card-body">
                        @foreach ($daySchedule as $schedule)
                        <a class="card card-primary card-outline mb-2" href="#">
                            <div class="card-header">
                                <h5 class="card-title text-bold text-dark">
                                    {{-- {{ $schedule->subject }} <br> --}}
                                    @if ($schedule->subject)
                                    {{ $schedule->subject }}
                                    @else
                                    {{ $schedule->classroom }}
                                    @endif
                                    <br>
                                    {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                </h5>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('styles')
<style>
    .five-cards-per-row .col-md {
        flex: 0 0 20%;
        max-width: 20%;
    }
</style>

@endpush
