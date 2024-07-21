@props(['subject', 'details' => true])

<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $subject->name }}</h5>

        <!-- <p class="card-text">
            Some quick example text to build on the card title and
            make up the bulk of the card's content.
        </p> -->
        <!-- display the teacher name with icon -->
        <p class="card-text">
            <i class="fas fa-chalkboard-teacher"></i>
            {{ $subject->teacher->name }}
        </p>

        @if (!auth()->user()->is_student && $details)
        <!-- edit button -->
        <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i>
            Edit
        </a>
        <!-- create score many button -->
        <a href="{{ route('scores.createMany', $subject) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Create Score
        </a>
        @endif
    </div>
</div>