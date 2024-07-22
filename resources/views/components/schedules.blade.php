@props([
    'schedules',
    'classroomid' => null,
])
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
                        <div class="card card-primary card-outline mb-2">
                            <div class="card-header">
                                <h5 class="card-title text-bold text-dark">
                                    {{-- {{ $schedule->subject }} <br> --}}
                                    @if ($schedule->subject)
                                    <a href="href="{{ $schedule->subject ? route('subjects.show', $schedule->subject) : route('classrooms.show', $schedule->classroom) }}">
                                        {{ $schedule->subject->name }}
                                    </a>
                                    @else
                                    {{-- {{ $schedule->classroom->name }} --}}
                                    <a href="{{ route('classrooms.show', $schedule->classroom) }}">
                                        {{ $schedule->classroom->name }}
                                    </a>
                                    @endif
                                    <br>
                                    {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                </h5>
                            </div>
                            @if ($classroomid)
                                <div class="card-footer">
                                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editScheduleModal" data-schedule="{{ $schedule }}">
                                    Edit
                                </button> --}}
                                {{-- <form action="{{ route('classrooms.schedules.destroy', ['classroom' => $classroomid, 'schedule' => $schedule->id]) }}" method="POST" class="d-inline"> --}}

                                    <form action="{{ route('classrooms.schedules.destroy', $schedule->id) }}" onsubmit="return confirm('Are you sure you want to delete this schedule?')" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                        <button type="submit" class="btn btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
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
