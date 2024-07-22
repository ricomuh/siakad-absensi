<x-main-layout>
    @section('title', $subject->name)

    <x-success-message />

    <div class="container-fluid">
        <div class="row">
            <!-- Informasi Mata Pelajaran - 50% -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Mata Pelajaran</h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $subject->name }}</h5>

                        <p class="card-text">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <strong>Guru:</strong> {{ $subject->teacher->name }}

                            <br>

                            {{-- untuk kelas --}}
                            <i class="fas fa-chalkboard"></i>
                            <strong>Untuk Kelas:</strong> {{ $subject->grade }}

                            <br>

                            {{-- jumlah kelas --}}
                            <i class="fas fa-users"></i>
                            <strong>Jumlah Kelas:</strong> {{ $subject->classrooms->count() }} Kelas
                        </p>
                    </div>
                </div>
            </div>

            <!-- Edit Mata Pelajaran - 50% -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Mata Pelajaran</h3>
                    </div>
                    <div class="card-body">
                        <!-- Tombol Edit mata pelajaran -->
                        <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                            Edit Mata Pelajaran
                        </a>

                        <!-- Tombol Hapus mata pelajaran -->
                        <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                                Hapus Mata Pelajaran
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- daftar kelas --}}
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Kelas</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="classrooms">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kelas</th>
                            <th>Guru</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($classRooms as $classroom)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('classrooms.show', $classroom) }}">
                                        {{ $classroom->name }}
                                    </a>
                                </td>
                                <td>{{ $classroom->teacher->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Tidak ada kelas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
            $("#classrooms").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#classrooms_wrapper .col-md-6:eq(0)');
        });
    </script>
    @endpush
</x-main-layout>
