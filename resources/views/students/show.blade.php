<x-main-layout>
    @section('title', $student->name)
    <x-success-message />

    <div class="container">
        <div class="card">
            <div class="card-header with-back-button">
                <a href="{{ route('students.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
                <h3 class="card-title">Detail Siswa</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="card-text">
                            <strong>Nama:</strong> {{ $student->name }}
                        </p>
                        <p class="card-text">
                            <strong>NIS:</strong> {{ $student->nis }}
                        </p>
                        <p class="card-text">
                            <strong>Kelas:</strong> {{ $student->classRoom?->classRoom->name ?? 'Tidak ada kelas' }}
                        </p>
                        <p class="card-text">
                            <strong>Email:</strong> {{ $student->email }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer">

                <a href="{{ route('students.edit', $student) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i>
                    Edit Siswa
                </a>
                <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i>
                        Hapus Siswa
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-main-layout>
