<x-main-layout>
    @section('title', 'Master Guru')
    <x-success-message />
    <div class="row justify-content-center w-full">
        <a href="{{ route('teachers.create') }}" class="btn btn-primary col-md-2 mb-2">Tambah Guru</a>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Guru</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="teachers">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">NIP</th>
                            <th scope="col">Mapel</th>
                            <th scope="col">Walikelas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teachers as $teacher)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ $teacher->nip }}</td>
                            <td>
                                @foreach ($teacher->subjects as $subject)
                                <a class="badge badge-primary" href="{{ route('subjects.show', $subject) }}"
                                >{{ $subject->name . ' (Kelas ' . $subject->grade . ')' }}</a>
                                @endforeach
                            </td>
                            <td>
                                @forelse ($teacher->teachingClassRooms as $classRoom)
                                <a href="{{ route('classrooms.show', $classRoom) }}" class="badge badge-info">{{ $classRoom->name }}</a>
                                @empty
                                <span class="badge badge-secondary">Tidak menjadi walikelas</span>
                                @endforelse
                            <td>
                                <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-info btn-sm">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


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
            $('#teachers').DataTable();
        });
    </script>
    @endpush
</x-main-layout>
