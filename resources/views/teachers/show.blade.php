<x-main-layout>
    @section('title', $teacher->name)
    <x-success-message />

    <div class="container">
        <div class="card">
            <div class="card-header with-back-button">
                <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
                <h3 class="card-title">Detail Guru</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="card-text">
                            <strong>Nama:</strong> {{ $teacher->name }}
                        </p>
                        <p class="card-text">
                            <strong>NIP:</strong> {{ $teacher->nip }}
                        </p>
                        <p class="card-text">
                            <strong>Mapel:</strong>
                            @forelse ($teacher->subjects as $subject)
                            <a class="badge badge-primary" href="{{ route('subjects.show', $subject) }}">
                                {{ $subject->name . ' (Kelas ' . $subject->grade . ')' }}
                            </a>
                            @empty
                            <span class="badge badge-secondary">Tidak mengajar mapel</span>
                            @endforelse
                        </p>
                        <p class="card-text">
                            <strong>Walikelas:</strong>
                            @forelse ($teacher->teachingClassRooms as $classRoom)
                            <a href="{{ route('classrooms.show', $classRoom) }}" class="badge badge-info">{{ $classRoom->name }}</a>
                            @empty
                            <span class="badge badge-secondary">Tidak menjadi walikelas</span>
                            @endforelse
                        </p>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i>
                    Edit Guru
                </a>
                <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus guru ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i>
                        Hapus Guru
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-main-layout>
