@props(['students', 'actions' => null, 'action' => false, 'subject' => null])
<div class="card col-12">
    <div class="card-header border-0">
        <h3 class="card-title">Students</h3>
        <!-- <div class="card-tools">
            <a href="#" class="btn btn-tool btn-sm">
                <i class="fas fa-download"></i>
            </a>
            <a href="#" class="btn btn-tool btn-sm">
                <i class="fas fa-bars"></i>
            </a>
        </div> -->
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Grade</th>
                    <th>Email</th>
                    @if ($actions == true)
                    <th>Average Scores</th>
                    <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{ $student->name }}
                    </td>
                    <td>
                        {{ $student->grade }}
                    </td>
                    <td>
                        {{ $student->email }}
                    </td>
                    @if ($actions == true)
                    <td>
                        @foreach ($student->average_scores as $type => $score)
                        <!-- badge -->
                        <span class="badge badge-{{ $score >= 75 ? 'success' : 'danger' }}">
                            {{ number_format($score, 1) }}
                            ({{ $type }})
                        </span>
                        @if ($loop->iteration % 3 == 0)
                        <br>
                        @endif
                        @endforeach
                    </td>
                    <td>
                        <form action="{{ route('subjects.students.remove', [$subject, $student]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                            <a class="btn btn-primary" href="{{ route('scores.showDetails', [$subject, $student]) }}">
                                Scores
                            </a>

                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>