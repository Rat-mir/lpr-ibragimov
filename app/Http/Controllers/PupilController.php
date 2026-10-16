<?php

namespace App\Http\Controllers;

use App\Http\Requests\PupilRequest;
use App\Models\Pupil;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use App\Models\Club;

class PupilController extends Controller
{
    public function index(Request $request)
{
    $query = Pupil::with(['schoolClass', 'clubs']);

    // Поиск по ФИО
    if ($search = $request->query('q')) {
        $query->where(
            'full_name',
            'like',
            "%{$search}%"
        );
    }

    // Фильтр по классу
    if ($schoolClassId = $request->query('school_class_id')) {
        $query->where(
            'school_class_id',
            $schoolClassId
        );
    }

    // Фильтр по льготе
    $benefit = $request->query('has_benefit');

    if ($benefit !== null && $benefit !== '') {
        $query->where(
            'has_benefit',
            (bool) $benefit
        );
    }

    // Твоя персональная сортировка:
    // full_name А → Я
    $query->orderBy('full_name');

    return view('pupils.index', [
        'title' => 'Ученики',

        'pupils' => $query
            ->paginate(4)
            ->withQueryString(),

        'classes' => SchoolClass::orderBy('name')->get(),
    ]);
}

    public function create()
{
    return view('pupils.form', [

        'title' => 'Новый ученик',

        'pupil' => new Pupil(),

        'classes' =>
            SchoolClass::orderBy('name')->get(),

        'clubs' =>
            Club::orderBy('name')->get(),
    ]);
}

    public function store(PupilRequest $request)
{
    $data = $request->validated();

    $clubIds = $data['clubs'] ?? [];

    unset($data['clubs']);

    $pupil = Pupil::create($data);

    $pupil->clubs()->sync($clubIds);

    return redirect()
        ->route('pupils.index')
        ->with(
            'status',
            "Добавлен ученик: {$pupil->full_name}"
        );
}

    public function edit(Pupil $pupil)
{
    $pupil->load('clubs');

    return view('pupils.form', [

        'title' =>
            'Редактирование ученика',

        'pupil' => $pupil,

        'classes' =>
            SchoolClass::orderBy('name')->get(),

        'clubs' =>
            Club::orderBy('name')->get(),
    ]);
}

    public function update(
    PupilRequest $request,
    Pupil $pupil
) {
    $data = $request->validated();

    $clubIds = $data['clubs'] ?? [];

    unset($data['clubs']);

    $pupil->update($data);

    $pupil->clubs()->sync($clubIds);

    return redirect()
        ->route('pupils.index')
        ->with(
            'status',
            'Изменения сохранены.'
        );
}

    public function destroy(Pupil $pupil)
    {
        $name = $pupil->full_name;

        $pupil->delete();

        return redirect()
            ->route('pupils.index')
            ->with(
                'status',
                "Удалено: {$name}"
            );
    }
}