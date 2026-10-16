@extends('layouts.app')

@section('content')

<h1>{{ $title }}</h1>

<form
    method="POST"
    class="col-lg-8"
    action="{{
        $pupil->exists
            ? route('pupils.update', $pupil)
            : route('pupils.store')
    }}"
>

    @csrf

    @if ($pupil->exists)
        @method('PUT')
    @endif


    {{-- Класс --}}

    <label class="form-label">
        Класс
    </label>

    <select
        name="school_class_id"
        class="form-select mb-2
        @error('school_class_id') is-invalid @enderror"
    >

        <option value="">
            Выберите класс
        </option>

        @foreach ($classes as $class)

            <option
                value="{{ $class->id }}"
                @selected(
                    old(
                        'school_class_id',
                        $pupil->school_class_id
                    ) == $class->id
                )
            >
                {{ $class->name }}
                — {{ $class->year }}
            </option>

        @endforeach

    </select>

    @error('school_class_id')

        <div class="invalid-feedback">
            {{ $message }}
        </div>

    @enderror


    {{-- ФИО --}}

    <label class="form-label mt-2">
        ФИО
    </label>

    <input
        name="full_name"
        value="{{
            old(
                'full_name',
                $pupil->full_name
            )
        }}"
        class="form-control
        @error('full_name') is-invalid @enderror"
    >

    @error('full_name')

        <div class="invalid-feedback">
            {{ $message }}
        </div>

    @enderror


    {{-- Дата рождения --}}

    <label class="form-label mt-2">
        Дата рождения
    </label>

    <input
        type="date"
        name="birth_date"
        value="{{
            old(
                'birth_date',
                $pupil->birth_date?->format('Y-m-d')
            )
        }}"
        class="form-control
        @error('birth_date') is-invalid @enderror"
    >

    @error('birth_date')

        <div class="invalid-feedback">
            {{ $message }}
        </div>

    @enderror


    {{-- Email --}}

    <label class="form-label mt-2">
        Email
    </label>

    <input
        type="email"
        name="email"
        value="{{
            old(
                'email',
                $pupil->email
            )
        }}"
        class="form-control
        @error('email') is-invalid @enderror"
    >

    @error('email')

        <div class="invalid-feedback">
            {{ $message }}
        </div>

    @enderror


    {{-- Средний балл --}}

    <label class="form-label mt-2">
        Средний балл
    </label>

    <input
        type="number"
        step="0.01"
        min="0"
        max="5"
        name="average_score"
        value="{{
            old(
                'average_score',
                $pupil->average_score
            )
        }}"
        class="form-control
        @error('average_score') is-invalid @enderror"
    >

    @error('average_score')

        <div class="invalid-feedback">
            {{ $message }}
        </div>

    @enderror


    {{-- Льгота --}}

    <div class="form-check my-3">

        <input
            type="checkbox"
            name="has_benefit"
            value="1"
            class="form-check-input"
            @checked(
                old(
                    'has_benefit',
                    $pupil->has_benefit
                )
            )
        >

        <label class="form-check-label">
            Есть льгота
        </label>

    </div>

<hr>

<h5>
    Кружки
</h5>

@php

    $selectedClubs = old(
        'clubs',
        $pupil->exists
            ? $pupil->clubs->pluck('id')->toArray()
            : []
    );

@endphp

<div class="row mb-3">

    @foreach ($clubs as $club)

        <div class="col-md-4">

            <div class="form-check">

                <input
                    type="checkbox"
                    name="clubs[]"
                    value="{{ $club->id }}"
                    class="form-check-input"
                    id="club{{ $club->id }}"
                    @checked(
                        in_array(
                            $club->id,
                            $selectedClubs
                        )
                    )
                >

                <label
                    class="form-check-label"
                    for="club{{ $club->id }}"
                >
                    {{ $club->name }}
                </label>

            </div>

        </div>

    @endforeach

</div>

@error('clubs.*')

    <div class="text-danger mb-3">
        {{ $message }}
    </div>

@enderror
    <button class="btn btn-primary">
        Сохранить
    </button>

    <a
        href="{{ route('pupils.index') }}"
        class="btn btn-secondary"
    >
        Отмена
    </a>

</form>

@endsection