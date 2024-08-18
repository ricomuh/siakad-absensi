<x-main-layout>
    @section('title', 'Sesi ' . $session->schedule->classSubject->subject->name . ' ' . $session->schedule->classSubject->classRoom->name)

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-widget widget-user-2">
                    <div class="card-header">
                        <h3 class="card-title">{{ $session->schedule->classSubject->subject->name . ' ' . $session->schedule->classSubject->classRoom->name }}</h3>
                    </div>
                    <div class="card-body">
                        {{-- (new \chillerlan\QRCode\QRCode)->render($session->uuid) --}}
                        <img src="{{
                        (new \chillerlan\QRCode\QRCode)->render(route('student.sessions.present', $session->uuid))
                         }}" alt="QR Code" class="img-fluid">
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('teacher.sessions.destroy', $session) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Tutup</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-widget widget-user-2">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Hadir</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody id="attendance-list">
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
    {{-- import moment --}}
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

        <script>
            const attendanceList = document.getElementById('attendance-list');

            function fetchAttendance() {
                fetch('{{ route('teacher.sessions.students', $session) }}')
                    .then(response => response.json())
                    .then(data => {
                        attendanceList.innerHTML = '';
                        data.forEach((attendance, index) => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${index + 1}</td>
                                <td>${attendance.name}</td>
                                <td>${moment(attendance.created_at).format('DD MMMM YYYY, HH:mm:ss')}</td>
                            `;
                            attendanceList.appendChild(tr);
                        });
                    });
            }

            fetchAttendance();
            setInterval(fetchAttendance, 5000);
        </script>
    @endpush
</x-main-layout>
