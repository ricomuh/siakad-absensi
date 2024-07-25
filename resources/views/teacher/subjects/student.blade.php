<x-main-layout>
    @section('title', $student->name . ' (' . $classSubject->subject->name . ' ' . $classSubject->classRoom->name . ')')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $student->name }} ({{ $classSubject->subject->name }} {{ $classSubject->classRoom->name }})</h1>
                <div class="card">
                    <div class="card-header with-back-button">
                        <a href="{{ route('teacher.classrooms.show', $classSubject->classRoom) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <h5 class="card-title">
                            Informasi Presensi Siswa
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="sessions">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Presensi</th>
                                    <th>Lokasi Presensi</th>
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
                                        @if ($session->studentPresent)
                                            <th>
                                                <p class="text-success">
                                                    Hadir pada {{ $session->studentPresent->created_at->format('H:i') }}
                                                </p>
                                            </th>
                                            <td>
                                                {{ $session->studentPresent->location }}
                                            </td>
                                        @else
                                            <th>
                                                <p class="text-danger text-center">
                                                    Tidak hadir
                                                </p>
                                            </th>
                                            <td>
                                                -
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
        $(function() {
            $('#sessions').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "order": [
                    [1, 'desc']
                ],
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    @endpush

</x-main-layout>
