@extends('layouts.app')

@section('content')

<h1>{{ $title }}</h1>

<p>
    Выберите школьный класс:
</p>

<div class="list-group col-md-5">

    @foreach ($classes as $class)

        <a
            class="list-group-item list-group-item-action"
            href="{{
                route(
                    'catalog.school-class',
                    ['schoolClass' => $class]
                )
            }}"
        >
            {{ $class }}
        </a>

    @endforeach

</div>

@endsection