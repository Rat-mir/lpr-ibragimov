<?php

namespace App\Http\Controllers;

use App\Http\Requests\PupilRequest;
use App\Models\Pupil;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class PupilController extends Controller
{
    public function index(Request $request)
    {
        $query = Pupil::with('schoolClass');

        if ($search = $request->query('q')) {

            $query->where(
                'full_name',
                'like',
                "%{$search}%"
            );
        }

        $query->orderBy('full_name');

        return view('pupils.index', [
            'title' => 'Ученики',

            'pupils' => $query
                ->paginate(4)
                ->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('pupils.form', [

            'title' => 'Новый ученик',

            'pupil' => new Pupil(),

            'classes' => SchoolClass::orderBy('name')
                ->get(),
        ]);
    }

    public function store(PupilRequest $request)
    {
        $pupil = Pupil::create(
            $request->validated()
        );

        return redirect()
            ->route('pupils.index')
            ->with(
                'status',
                "Добавлен ученик: {$pupil->full_name}"
            );
    }

    public function edit(Pupil $pupil)
    {
        return view('pupils.form', [

            'title' => 'Редактирование ученика',

            'pupil' => $pupil,

            'classes' => SchoolClass::orderBy('name')
                ->get(),
        ]);
    }

    public function update(
        PupilRequest $request,
        Pupil $pupil
    ) {
        $pupil->update(
            $request->validated()
        );

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