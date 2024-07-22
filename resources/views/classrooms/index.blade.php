<x-main-layout>
    @section('title', 'Master Kelas')
    <x-success-message />
    <div class="row justify-content-center w-full">
        <a href="{{ route('classrooms.create') }}" class="btn btn-primary col-2 mb-2">Tambah Kelas</a>
    </div>
    <div class="row">
        @foreach ($classrooms as $classroom)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <x-classroom-card :classroom="$classroom" />
        </div>
        @endforeach
    </div>
</x-main-layout>
