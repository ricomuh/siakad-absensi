<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $title }}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form @if(isset($action)) action="{{ $action }}" @endif method="POST">
        @csrf
        @if (isset($method))
        @method($method)
        @endif
        <div class="card-body {{ $class ?? '' }}">
            <!-- display errors -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
            {{ $slot }}
        </div>

        @if (!isset($footer))
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ $submit ?? 'Submit' }}</button>
        </div>
        @else
        <button type="submit" class="btn btn-primary ml-3">
            {{ $submit ?? 'Submit' }}
        </button>
        @endif

    </form>
    @if (isset($footer))
    <div class="card-footer">
        {{ $footer }}
    </div>
    @endif
</div>