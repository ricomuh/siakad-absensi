@props(['schedules'])
@php
$colors = [
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
    <div class="container-fluid h-100 row">
        @foreach ($schedules as $day => $daySchedule)
        <!-- add x gap -->
        <div class="card card-row {{ $colors[$loop->iteration] }} mr-3 col-lg-3 col-md-6 col-sm-12">
            <div class="card-header">
                <h3 class="card-title">
                    {{ ucfirst($day) }}
                </h3>
            </div>
            <div class="card-body">
                @foreach ($daySchedule as $schedule)

                <a class="card card-primary card-outline" href="{{ route('subjects.show', $schedule->subject) }}">
                    <div class="card-header">
                        <h5 class="card-title text-bold text-dark">
                            {{ $schedule->subject->name }} <br>
                            {{ $schedule->start_time }} - {{ $schedule->end_time }}
                        </h5>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</section>