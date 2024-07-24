<x-main-layout>
    @section('title', 'Mata Pelajaran')

    <x-success-message />

    <div class="container-fluid">
        @foreach ($subjects as $subject)
            <div class="card card-widget widget-user-2">
                {{-- <h2>{{ $subject->name . ' untuk kelas ' . $subject->grade }}</h2> --}}
                <div class="card-header">
                    <h3 class="card-title">{{ $subject->name . ' untuk kelas ' . $subject->grade }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                    @foreach ($subject->classRooms as $classRoom)
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <x-classroom-card :classroom="$classRoom->classRoom" :link="route('teacher.classrooms.show', $classRoom->classRoom)" />
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-main-layout>
