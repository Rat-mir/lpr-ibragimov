@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">

    <h1>{{ $title }}</h1>

    <a
        href="{{ route('pupils.create') }}"
        class="btn btn-success align-self-center"
    >
        + Добавить ученика
    </a>

</div>

<form method="GET" class="row g-2 mb-3">

    <div class="col-md-4">

        <input
            name="q"
            value="{{ request('q') }}"
            class="form-control"
            placeholder="Поиск по ФИО"
        >

    </div>

    <div class="col-auto">

        <button class="btn btn-secondary">
            Найти
        </button>

    </div>

</form>

<table class="table table-striped align-middle">

    <thead>

        <tr>
            <th>ID</th>
            <th>ФИО</th>
            <th>Класс</th>
            <th>Дата рождения</th>
            <th>Средний балл</th>
            <th>Льгота</th>
            <th></th>
        </tr>

    </thead>

    <tbody>

        @foreach ($pupils as $pupil)

            <tr>

                <td>
                    {{ $pupil->id }}
                </td>

                <td>
                    {{ $pupil->full_name }}
                </td>

                <td>
                    {{ $pupil->schoolClass->name }}
                </td>

                <td>
                    {{ $pupil->birth_date->format('d.m.Y') }}
                </td>

                <td>
                    {{ $pupil->average_score }}
                </td>

                <td>

                    @if ($pupil->has_benefit)

                        <span class="badge bg-success">
                            Есть
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            Нет
                        </span>

                    @endif

                </td>

                <td class="text-end">

                    <a
                        href="{{ route('pupils.edit', $pupil) }}"
                        class="btn btn-sm btn-outline-primary"
                    >
                        Изменить
                    </a>

                    <form
                        method="POST"
                        action="{{ route('pupils.destroy', $pupil) }}"
                        class="d-inline"
                        onsubmit="return confirm('Удалить ученика?')"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            class="btn btn-sm btn-outline-danger"
                        >
                            Удалить
                        </button>

                    </form>

                </td>

            </tr>

        @endforeach

    </tbody>

</table>

{{ $pupils->links() }}

@endsection