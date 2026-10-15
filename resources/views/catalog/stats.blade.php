@extends('layouts.app')

@section('content')

<h1>{{ $title }}</h1>

<div class="card mt-4">
    <div class="card-body">

        <p>
            <strong>
                Количество учеников:
            </strong>
            {{ $count }}
        </p>

        <p>
            <strong>
                Средний балл:
            </strong>

            {{
                number_format(
                    $avg,
                    2,
                    ',',
                    ' '
                )
            }}
        </p>

        <p>
            <strong>
                Минимальный балл:
            </strong>

            {{
                number_format(
                    $min,
                    2,
                    ',',
                    ' '
                )
            }}
        </p>

        <p>
            <strong>
                Максимальный балл:
            </strong>

            {{
                number_format(
                    $max,
                    2,
                    ',',
                    ' '
                )
            }}
        </p>

    </div>
</div>

@endsection