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
                                        <form action="#" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus murid ini dari kelas?')">
                                            @csrf
                                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                        {{-- <form action="{{ route('classrooms.remove_student', $classroom) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus murid ini dari kelas?')">
                                            @csrf
                                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form> --}}
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
                                            <form action="#" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?')">
                                                @csrf
                                                @method('DELETE')
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
    <x-schedules :schedules="$schedules" />

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
        $(function () {
            $('#students').DataTable();
            $('#subjects').DataTable();
        });
    </script>
    @endpush
</x-main-layout>

