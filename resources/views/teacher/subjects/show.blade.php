<x-main-layout>
    @section('title', $subject->name . ' (' . $classRoom->name . ')')

    <div class="container-fluid">
        <div class="row">

            <!-- Informasi Kelas & Mata Pelajaran -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header with-back-button">
                        <a href="{{ route('teacher.subjects.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <h3 class="card-title">{{ $subject->name . ' (' . $classRoom->name . ')' }}</h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $classRoom->name }}</h5>
                        <p class="card-text">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <strong>Guru:</strong> {{ $classRoom->teacher->name }}
                            <br>
                            <i class="fas fa-users"></i>
                            <strong>Murid:</strong> {{ $classRoom->students->count() }} Murid
                        </p>
                    </div>
                </div>
            </div>

            <!-- Mulai Sesi -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Mulai Sesi</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('teacher.sessions.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="class_subject_id" value="{{ $classSubject->id }}">
                            <select name="schedule_id" class="form-control mb-3">
                                <option value="">Pilih Jadwal</option>
                                @foreach ($schedules as $schedule)
                                    <option value="{{ $schedule->id }}" @selected($currentSchedule?->id == $schedule->id)>
                                        {{ $schedule->dayName }} - {{ $schedule->start_time }} s/d {{ $schedule->end_time }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-play"></i>
                                Mulai Sesi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Informasi Presensi
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped" id="murid">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Kehadiran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>
                                                {{ $student->sessions_count }} dari {{ $sessions->count() }} sesi hadir
                                                @if ($student->sessions_count == $sessions->count())
                                                    <span class="badge badge-success">100%</span>
                                                @elseif ($student->sessions_count < $sessions->count() * 0.5)
                                                    <span class="badge badge-danger">
                                                        {{ $student->sessions_count / $sessions->count() * 100 }}%
                                                    </span>
                                                @else
                                                    <span class="badge badge-warning">
                                                        {{ $student->sessions_count / $sessions->count() * 100 }}%
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Informasi Sesi
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped" id="presensi">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Presensi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sessions as $session)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $session->created_at->isoFormat('dddd, D MMMM Y') }}</td>
                                            <td>
                                                {{ $session->created_at->isoFormat('HH:mm') }}
                                                @if ($session->closed_at)
                                                    s/d {{ $session->closed_at->isoFormat('HH:mm') }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $session->studentPresents->count() }} dari {{ $students->count() }} murid hadir
                                                @if ($session->studentPresents->count() == $students->count())
                                                    <span class="badge badge-success">100%</span>
                                                @elseif ($session->studentPresents->count() < $students->count() * 0.5)
                                                    <span class="badge badge-danger">
                                                        {{ $session->studentPresents->count() / $students->count() * 100 }}%
                                                    </span>
                                                @else
                                                    <span class="badge badge-warning">
                                                        {{ $session->studentPresents->count() / $students->count() * 100 }}%
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-schedules :schedules="$mappedSchedules" />

    @push('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @endpush

    @push('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

    <script>
        $(function() {
            $('#murid').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $('#presensi').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    @endpush
</x-main-layout>
