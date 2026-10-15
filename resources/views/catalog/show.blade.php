@extends('layouts.app')

@section('content')

<h1>{{ $pupil['full_name'] }}</h1>

<dl class="row mt-4">

    <dt class="col-sm-3">ID</dt>
    <dd class="col-sm-9">
        {{ $pupil['id'] }}
    </dd>

    <dt class="col-sm-3">Код</dt>
    <dd class="col-sm-9">
        {{ $pupil['code'] }}
    </dd>

    <dt class="col-sm-3">ФИО</dt>
    <dd class="col-sm-9">
        {{ $pupil['full_name'] }}
    </dd>

    <dt class="col-sm-3">Класс</dt>
    <dd class="col-sm-9">
        {{ $pupil['school_class'] }}
    </dd>

    <dt class="col-sm-3">
        Дата рождения
    </dt>
    <dd class="col-sm-9">
        {{ $pupil['birth_date'] }}
    </dd>

    <dt class="col-sm-3">Email</dt>
    <dd class="col-sm-9">
        {{ $pupil['email'] }}
    </dd>

    <dt class="col-sm-3">
        Средний балл
    </dt>
    <dd class="col-sm-9">
        {{
            number_format(
                $pupil['average_score'],
                2,
                ',',
                ' '
            )
        }}
    </dd>

    <dt class="col-sm-3">Льгота</dt>
    <dd class="col-sm-9">

        @if ($pupil['has_benefit'])

            <span class="badge bg-success">
                Есть
            </span>

        @else

            <span class="badge bg-secondary">
                Нет
            </span>

        @endif

    </dd>

</dl>

<a
    href="{{ route('catalog.index') }}"
    class="btn btn-secondary"
>
    ← К каталогу
</a>

@endsection