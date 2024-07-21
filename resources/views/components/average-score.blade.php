@props(['type', 'value', 'subject' => null, 'student' => null])

@php
$colors =[
'bg-success', 'bg-info', 'bg-warning', 'bg-danger'
];
$color = 0;

if ($value < 50) { $color=3; } elseif ($value < 70) { $color=2; } elseif ($value < 90) { $color=1; } else { $color=0; } @endphp <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box {{ $colors[$color] }}">
        <div class="inner">
            <h3>

                {{ number_format($value, 1) }}
                <sup style="font-size: 20px">%</sup>
            </h3>

            <p>
                {{ $type }}
            </p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        @if ($subject && $student)
        <a href="{{ route('scores.showDetails', [$subject, $student]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        @endif
    </div>
    </div>