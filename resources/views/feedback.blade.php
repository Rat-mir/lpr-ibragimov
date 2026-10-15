@extends('layouts.app')

@section('content')

<h1>{{ $title }}</h1>

<form
    method="POST"
    action="{{ route('feedback.send') }}"
    class="col-md-6"
>

    @csrf

    <div class="mb-3">

        <label class="form-label">
            Имя
        </label>

        <input
            type="text"
            name="name"
            class="form-control"
            placeholder="Введите имя"
        >

    </div>

    <div class="mb-3">

        <label class="form-label">
            Сообщение
        </label>

        <textarea
            name="message"
            class="form-control"
            rows="4"
            placeholder="Введите сообщение"
        ></textarea>

    </div>

    <button class="btn btn-primary">
        Отправить
    </button>

</form>

@endsection