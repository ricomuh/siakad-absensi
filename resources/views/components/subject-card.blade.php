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
$link = auth()->user()->role_id == \App\Enums\RoleEnum::TEACHER ? route('teacher.subjects.show', $subject) : route('subjects.show', $subject);
@endphp
<div class="card card-widget widget-user-2">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <!-- color -->
    <a class="widget-user-header {{ $colors[$subject->id % count($colors)] }}" href="{{ $link }}">
        <div class="widget-user-image" style="display: inline-block;">
            <div class="img-circle elevation-2" style="background-color: #3c8dbc; width: 48px; height: 48px; text-align: center; line-height: 35px; font-size: 18px; color: #fff; font-weight: bold; display: flex; align-items: center; justify-content: center;">
                {{ substr($subject->name, 0, 1) . $subject->grade }}
            </div>
        </div>

        <div class=" row d-flex" style="margin-top: 10px;">
            <h5 class="card-title col-12" style="display: inline-block; font-weight: bold">{{ $subject->name }} untuk kelas {{ $subject->grade }}
            </h5>
            <p class="card-text col-12" style="display: inline-block;">
                <i class="fas fa-chalkboard-teacher"></i>
                {{ $subject->teacher->name }}
            </p>
        </div>
    </a>
    <div class="card-footer p-0">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ $link }}#students" class="nav-link">
                    Jumlah Kelas <span class="float-right badge bg-info">{{ $subject->class_rooms_count }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ $link }}#schedules" class="nav-link">
                    Jumlah Jadwal <span class="float-right badge bg-info">{{ $subject->schedules_count }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- /.widget-user -->
