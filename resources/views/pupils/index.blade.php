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

    <div class="col-md-3">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            class="form-control"
            placeholder="Поиск по ФИО"
        >
    </div>

    <div class="col-md-3">
        <select
            name="school_class_id"
            class="form-select"
        >
            <option value="">
                Все классы
            </option>

            @foreach ($classes as $class)
                <option
                    value="{{ $class->id }}"
                    @selected(
                        request('school_class_id') == $class->id
                    )
                >
                    {{ $class->name }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="col-md-3">
        <select
            name="has_benefit"
            class="form-select"
        >
            <option value="">
                Любая льгота
            </option>

            <option
                value="1"
                @selected(request('has_benefit') === '1')
            >
                Есть льгота
            </option>

            <option
                value="0"
                @selected(request('has_benefit') === '0')
            >
                Нет льготы
            </option>
        </select>
    </div>

    <div class="col-auto">
        <button class="btn btn-primary">
            Применить
        </button>
    </div>

    <div class="col-auto">
        <a
            href="{{ route('pupils.index') }}"
            class="btn btn-secondary"
        >
            Сбросить
        </a>
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
            <th>Кружки</th>
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


                {{-- Кружки --}}
                <td>

                    @forelse ($pupil->clubs as $club)

                        <span class="badge bg-info text-dark">
                            {{ $club->name }}
                        </span>

                    @empty

                        <span class="text-muted">
                            Нет
                        </span>

                    @endforelse

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