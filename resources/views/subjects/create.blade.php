<x-main-layout>
    @section('title', 'Tambah Mata Pelajaran')
    <x-success-message />
    <div class="container">
        <div class="card">
            <div class="card-header with-back-button">
                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
                <h3 class="card-title">Tambah Mata Pelajaran</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('subjects.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Mata Pelajaran</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="grade">Tingkat</label>
                        <select name="grade" id="grade" class="form-control @error('grade') is-invalid @enderror">
                            <option value="">Pilih Tingkat</option>
                            @foreach (range(1, 12) as $grade)
                            <option value="{{ $grade }}" {{ old('grade') == $grade ? 'selected' : '' }}>
                                {{ $grade }}
                            </option>
                            @endforeach
                        </select>
                        @error('grade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="teacher_id">Guru Pengajar</label>
                        <select name="teacher_id" id="teacher_id" class="form-control @error('teacher_id') is-invalid @enderror">
                            <option value="">Pilih Guru Pengajar</option>
                            @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

</x-main-layout>
