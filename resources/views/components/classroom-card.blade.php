<!-- Widget: user widget style 2 -->
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
<div class="card card-widget widget-user-2">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <!-- color -->
    <a class="widget-user-header {{ $colors[$classroom->id % count($colors)] }}" href="{{ route('classrooms.show', $classroom) }}">
        <div class="widget-user-image" style="display: inline-block;">
            <div class="img-circle elevation-2" style="background-color: #3c8dbc; width: 48px; height: 48px; text-align: center; line-height: 35px; font-size: 18px; color: #fff; font-weight: bold; display: flex; align-items: center; justify-content: center;">
                {{-- Class 7 n -> C7N --}}
                {{ implode('', array_map(function ($word) { return str($word)->substr(0, 1)->upper(); }, explode(' ', $classroom->name))) }}
            </div>
        </div>

        <div class=" row d-flex" style="margin-top: 10px;">
            <h5 class="card-title col-12" style="display: inline-block; font-weight: bold">{{ $classroom->name }}
            </h5>
            <p class="card-text col-12" style="display: inline-block;">
                <i class="fas fa-chalkboard-teacher"></i>
                {{ $classroom->teacher->name }}
            </p>
        </div>
    </a>
    <div class="card-footer p-0">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('classrooms.show', $classroom) }}#students" class="nav-link">
                    Jumlah Murid <span class="float-right badge bg-info">{{ $classroom->students_count }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('classrooms.show', $classroom) }}#subjects" class="nav-link">
                    Jumlah Mapel <span class="float-right badge bg-info">{{ $classroom->subjects_count }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- /.widget-user -->
