<x-main-layout>
    @section('title', 'Master Mata Pelajaran')
    <x-success-message />
    <div class="row justify-content-center w-full">
        <a href="{{ route('subjects.create') }}" class="btn btn-primary col-md-2 mb-2">Tambah Mata Pelajaran</a>
    </div>

    {{-- filter form --}}
    <div class="row justify-content-center w-full">
        <form action="{{ route('subjects.index') }}" method="GET" class="col-md-6">
            <div class="input-group mb-3">
                {{-- guru --}}
                <select name="teacher_id" class="form-control">
                    <option value="">Pilih Guru</option>
                    @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                    @endforeach
                </select>
                {{-- kelas --}}
                <select name="grade" class="form-control">
                    <option value="">Pilih Kelas</option>
                    @foreach ($grades as $grade)
                    <option value="{{ $grade }}" {{ request('grade') == $grade ? 'selected' : '' }}>
                        {{ $grade }}
                    </option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Filter</button>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        @foreach ($subjects as $subject)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <x-subject-card :subject="$subject" />
        </div>
        @endforeach
    </div>
</x-main-layout>
