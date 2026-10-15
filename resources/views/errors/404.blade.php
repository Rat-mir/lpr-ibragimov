@extends('layouts.app')

@section('content')

<div class="text-center py-5">

    <h1 class="display-1">
        404
    </h1>

    <h2>
        Страница не найдена
    </h2>

    <p class="text-muted">
        Запрошенный путь:
        <strong>
            {{ request()->path() }}
        </strong>
    </p>

    <a
        href="{{ route('catalog.index') }}"
        class="btn btn-primary"
    >
        Вернуться в каталог
    </a>

</div>

@endsection