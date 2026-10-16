@extends('layouts.app')

@section('content')

<h1 class="mb-4">
    {{ $title }}
</h1>

<table class="table table-striped align-middle">

    <thead>
        <tr>
            <th>ID</th>
            <th>Класс</th>
            <th>Учебный год</th>
            <th>Количество учеников</th>
            <th></th>
        </tr>
    </thead>

    <tbody>

        @foreach ($classes as $class)

            <tr>

                <td>
                    {{ $class->id }}
                </td>

                <td>
                    {{ $class->name }}
                </td>

                <td>
                    {{ $class->year }}
                </td>

                <td>
                    <span class="badge bg-primary">
                        {{ $class->pupils_count }}
                    </span>
                </td>

                <td class="text-end">

                    <form
                        method="POST"
                        action="{{
                            route(
                                'school-classes.destroy',
                                $class
                            )
                        }}"
                        onsubmit="
                            return confirm(
                                'Удалить класс {{ $class->name }}? ' +
                                'Вместе с ним будут удалены ученики: ' +
                                '{{ $class->pupils_count }}'
                            )
                        "
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            class="btn btn-sm btn-danger"
                        >
                            Удалить
                        </button>

                    </form>

                </td>

            </tr>

        @endforeach

    </tbody>

</table>

@endsection