@extends('layouts.app')

@section('content')

<h1 class="mb-3">{{ $title }}</h1>

<form
    method="GET"
    action="{{ route('catalog.index') }}"
    class="row g-2 mb-4"
>

    <div class="col-md-4">
        <input
            type="text"
            name="q"
            value="{{ $search }}"
            class="form-control"
            placeholder="ФИО ученика..."
        >
    </div>

    <div class="col-md-3">
        <select
            name="sort"
            class="form-select"
        >
            <option
                value="full_name"
                @selected($sort === 'full_name')
            >
                По ФИО
            </option>

            <option
                value="birth_date"
                @selected($sort === 'birth_date')
            >
                По дате рождения
            </option>

            <option
                value="average_score"
                @selected($sort === 'average_score')
            >
                По среднему баллу
            </option>
        </select>
    </div>

    <div class="col-auto">
        <button class="btn btn-primary">
            Найти
        </button>
    </div>

</form>

<table class="table table-striped table-bordered align-middle">

    <thead>
    <tr>
        <th>№</th>
        <th>ФИО</th>
        <th>Класс</th>
        <th>Дата рождения</th>
        <th>Средний балл</th>
        <th>Льгота</th>
    </tr>
    </thead>

    <tbody>

    @forelse ($pupils as $pupil)

        <tr>

            <td>
                {{ $loop->iteration }}
            </td>

            <td>
                <a href="{{
                    route(
                        'catalog.show',
                        ['id' => $pupil['id']]
                    )
                }}">
                    {{ $pupil['full_name'] }}
                </a>
            </td>

            <td>
                <a href="{{
                    route(
                        'catalog.school-class',
                        ['schoolClass' => $pupil['school_class']]
                    )
                }}">
                    {{ $pupil['school_class'] }}
                </a>
            </td>

            <td>
                {{ $pupil['birth_date'] }}
            </td>

            <td>
                {{
                    number_format(
                        $pupil['average_score'],
                        2,
                        ',',
                        ' '
                    )
                }}
            </td>

            <td>
                @if ($pupil['has_benefit'])

                    <span class="badge bg-success">
                        Есть
                    </span>

                @else

                    <span class="badge bg-secondary">
                        Нет
                    </span>

                @endif
            </td>

        </tr>

    @empty

        <tr>
            <td
                colspan="6"
                class="text-muted"
            >
                Ничего не найдено.
            </td>
        </tr>

    @endforelse

    </tbody>
</table>

@endsection