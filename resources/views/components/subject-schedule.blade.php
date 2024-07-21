@props(['subject', 'schedules'])
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>
                    Schedules for {{ $subject->name }}
                </h1>
            </div>
        </div>
    </div>
</section>
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

$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

@endphp

<section class="content pb-3">
    @if (!auth()->user()->is_student)
    <x-form-card method="POST" action="{{ route('subjects.schedules.add', $subject->id) }}" title="Add Schedule">
        <x-input-group name="day" label="Day" :value="old('day')" :error="$errors->first('day')">
            <select name="day" class="form-control">
                <option value="" selected disabled>--Select Day--</option>
                @foreach ($days as $key => $day)
                <option value="{{ $key+1 }}">{{ ucfirst($day) }}</option>
                @endforeach
            </select>
        </x-input-group>
        <!-- 24hrs format -->
        <x-input-group name="start_time" label="Start Time" type="time" :value="old('start_time')" :error="$errors->first('start_time')" min="08:00" max="17:00" />
        <x-input-group name="end_time" label="End Time" type="time" :value="old('end_time')" :error="$errors->first('end_time')" />
        <input type="hidden" name="subject_id" value="{{ $subject->id }}">
    </x-form-card>
    @endif
    <div class="container-fluid h-100 row">
        @foreach ($schedules as $day => $daySchedule)
        <!-- add x gap -->
        <div class="card card-row {{ $colors[$loop->iteration] }} mr-3 col-lg-4 col-md-6 col-sm-12">
            <div class="card-header">
                <h3 class="card-title">
                    {{ ucfirst($day) }}
                </h3>
            </div>
            <div class="card-body">
                @foreach ($daySchedule as $schedule)

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title text-bold text-dark">
                            {{ $schedule['start_time'] }} - {{ $schedule['end_time'] }}
                        </h5>
                        <!-- delete button if the role is not student -->
                        @if (!auth()->user()->is_student)
                        <form action="{{ route('subjects.schedules.remove', $schedule['id']) }}" method="POST" class="float-right" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach


        @push('scripts')
        <!-- Ekko Lightbox -->
        <script src="{{ asset('plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
        <!-- overlayScrollbars -->
        <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <!-- Filterizr-->
        <script src="{{ asset('plugins/filterizr/jquery.filterizr.min.js') }}"></script>
        <!-- Page specific script -->
        <script>
            $(function() {

            })
        </script>
        @endpush
    </div>
</section>