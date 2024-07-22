<x-main-layout>
    @section('title', $classroom->name)
    <x-success-message />

    <div class="container-fluid">
        <div class="row">
            <!-- Informasi Kelas - 50% -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header with-back-button">
                        <a href="{{ route('classrooms.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <h3 class="card-title">Informasi Kelas</h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $classroom->name }}</h5>

                        <p class="card-text">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <strong>Guru:</strong> {{ $classroom->teacher->name }}

                            <br>

                            <i class="fas fa-users"></i>
                            <strong>Murid:</strong> {{ $classroom->students->count() }} Murid
                        </p>
                    </div>
                </div>
            </div>

            <!-- Edit Kelas - 50% -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Kelas</h3>
                    </div>
                    <div class="card-body">
                        <!-- Tombol Edit kelas -->
                        <a href="{{ route('classrooms.edit', $classroom) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                            Edit Kelas
                        </a>

                        <!-- Tombol Hapus kelas -->
                        <form action="{{ route('classrooms.destroy', $classroom) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                                Hapus Kelas
                            </button>
                        </form>

                        <!-- Tombol Tambah Murid -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addStudentModal">
                            <i class="fas fa-user-plus"></i>
                            Tambah Murid
                        </button>

                        <!-- Tombol Tambah Mata Pelajaran -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addSubjectModal">
                            <i class="fas fa-book"></i>
                            Tambah Mata Pelajaran
                        </button>

                        <!-- Tombol Tambah Jadwal -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addScheduleModal">
                            <i class="fas fa-calendar-plus"></i>
                            Tambah Jadwal
                        </button>

                        <!-- Tombol List Jadwal -->
                        {{-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#scheduleModal">
                            <i class="fas fa-calendar-alt"></i>
                            List Jadwal
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Daftar Murid - 60% -->
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Murid</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="students">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama</th>
                                    <th style="width: 40px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td class="d-flex">
                                        <a href="{{ route('students.show', $student) }}" class="btn btn-info btn-sm me-2">
                                            <i class="fas fa-eye"></i>
                                            Detail
                                        </a>
                                        {{-- <form action="#" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus murid ini dari kelas?')">
                                            @csrf
                                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form> --}}
                                        <form action="{{ route('classrooms.students.destroy', $classroom) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus murid ini dari kelas?')">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Mata Pelajaran - 40% -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Mata Pelajaran</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="subjects">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama</th>
                                    <th>Guru</th>
                                    <th style="width: 40px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subjects as $subject)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->teacher->name }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('subjects.show', $subject) }}" class="btn btn-info btn-sm me-2">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('classrooms.subjects.destroy', $classroom) }}"
                                            method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
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

    {{-- schedules --}}
    <x-schedules :schedules="$schedules" :classroomid="$classroom->id" />

    <!-- Modal Tambah Murid -->
    <x-modal name="addStudentModal">
        <form action="{{ route('classrooms.students.store', $classroom) }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Tambah Murid ke Kelas {{ $classroom->name }}</h5>
                <!-- For Bootstrap 4 -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select name="student_id" class="form-control" required>
                    <option selected disabled>Pilih Murid</option>
                    @foreach ($allStudents as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Tambah Mata Pelajaran -->
    <x-modal name="addSubjectModal">
        <form action="{{ route('classrooms.subjects.store', $classroom) }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="addSubjectModalLabel">Tambah Mata Pelajaran ke Kelas {{ $classroom->name }}</h5>
                <!-- For Bootstrap 4 -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select name="subject_id" class="form-control" required>
                    <option selected disabled>Pilih Mata Pelajaran</option>
                    @foreach ($allSubjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name . ' - ' . $subject->teacher->name . ' (Kelas ' . $subject->grade . ')' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Tambah Jadwal -->
    <x-modal name="addScheduleModal">
        <form action="{{ route('classrooms.schedules.store', $classroom) }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="addScheduleModalLabel">Tambah Jadwal ke Kelas {{ $classroom->name }}</h5>
                <!-- For Bootstrap 4 -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="day">Hari</label>
                    <select name="day" class="form-control" required>
                        <option selected disabled>Pilih Hari</option>
                        <option value="0">Minggu</option>
                        <option value="1">Senin</option>
                        <option value="2">Selasa</option>
                        <option value="3">Rabu</option>
                        <option value="4">Kamis</option>
                        <option value="5">Jumat</option>
                        <option value="6">Sabtu</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="start_time">Waktu Mulai</label>
                    <input type="time" name="start_time" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="end_time">Waktu Selesai</label>
                    <input type="time" name="end_time" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="subject_id">Mata Pelajaran</label>
                    <select name="subject_id" class="form-control" required>
                        <option selected disabled>Pilih Mata Pelajaran</option>
                        @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Edit Jadwal -->
    <x-modal name="editScheduleModal">
        <form action="{{ route('classrooms.schedules.update', $classroom) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="schedule_id" id="schedule_id">
            <div class="modal-header">
                <h5 class="modal-title" id="editScheduleModalLabel">Edit Jadwal</h5>
                <!-- For Bootstrap 4 -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="day">Hari</label>
                    <select name="day" class="form-control" required>
                        <option selected disabled>Pilih Hari</option>
                        <option value="0">Minggu</option>
                        <option value="1">Senin</option>
                        <option value="2">Selasa</option>
                        <option value="3">Rabu</option>
                        <option value="4">Kamis</option>
                        <option value="5">Jumat</option>
                        <option value="6">Sabtu</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="start_time">Waktu Mulai</label>
                    <input type="time" name="start_time" class="form-control">
                </div>
                <div class="form-group">
                    <label for="end_time">Waktu Selesai</label>
                    <input type="time" name="end_time" class="form-control">
                </div>
                <div class="form-group">
                    <label for="subject_id">Mata Pelajaran</label>
                    <select name="subject_id" class="form-control" required>
                        <option selected disabled>Pilih Mata Pelajaran</option>
                        @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Edit</button>
            </div>
        </form>
    </x-modal>



    @push('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- Modal -->
    <style>
        .modal-body {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
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
        $(function () {
            $('#students').DataTable();
            $('#subjects').DataTable();
        });

        $('#editScheduleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var schedule = button.data('schedule');

            var modal = $(this);
            modal.find('.modal-body select[name="day"]').val(schedule.day);
            // start time: 08:00:00 to 08:00
            modal.find('.modal-body input[name="start_time"]').val(schedule.start_time.slice(0, 5));
            modal.find('.modal-body input[name="end_time"]').val(schedule.end_time.slice(0, 5));
            modal.find('.modal-body select[name="subject_id"]').val(schedule.subject.id);
            modal.find('.modal-body input[name="schedule_id"]').val(schedule.id);

            console.log(schedule);
        });
    </script>
    @endpush
</x-main-layout>

