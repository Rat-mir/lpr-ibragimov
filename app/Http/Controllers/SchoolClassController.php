<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;

class SchoolClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::withCount('pupils')
            ->orderBy('name')
            ->get();

        return view('school-classes.index', [
            'title' => 'Школьные классы',
            'classes' => $classes,
        ]);
    }

    public function destroy(SchoolClass $schoolClass)
    {
        $count = $schoolClass->pupils()->count();

        $name = $schoolClass->name;

        $schoolClass->delete();

        return redirect()
            ->route('school-classes.index')
            ->with(
                'status',
                "Удалён класс {$name}. "
                . "Вместе с ним удалено учеников: {$count}."
            );
    }
}