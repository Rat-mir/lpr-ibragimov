<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    private function pupils(): array
    {
        return [
            [
                'id' => 1,
                'code' => 'PUP-001',
                'full_name' => 'Абдрахманов Алихан',
                'school_class' => '9А',
                'birth_date' => '2011-03-15',
                'email' => 'alikhan@example.com',
                'average_score' => 4.75,
                'has_benefit' => true,
            ],
            [
                'id' => 2,
                'code' => 'PUP-002',
                'full_name' => 'Ахметова Амина',
                'school_class' => '9А',
                'birth_date' => '2011-07-21',
                'email' => 'amina@example.com',
                'average_score' => 4.92,
                'has_benefit' => false,
            ],
            [
                'id' => 3,
                'code' => 'PUP-003',
                'full_name' => 'Беков Данияр',
                'school_class' => '9Б',
                'birth_date' => '2011-01-09',
                'email' => 'daniyar@example.com',
                'average_score' => 4.10,
                'has_benefit' => false,
            ],
            [
                'id' => 4,
                'code' => 'PUP-004',
                'full_name' => 'Иванова София',
                'school_class' => '9Б',
                'birth_date' => '2011-11-28',
                'email' => 'sofia@example.com',
                'average_score' => 4.68,
                'has_benefit' => true,
            ],
            [
                'id' => 5,
                'code' => 'PUP-005',
                'full_name' => 'Касымов Арсен',
                'school_class' => '10А',
                'birth_date' => '2010-05-12',
                'email' => 'arsen@example.com',
                'average_score' => 3.85,
                'has_benefit' => false,
            ],
            [
                'id' => 6,
                'code' => 'PUP-006',
                'full_name' => 'Садыкова Диана',
                'school_class' => '10А',
                'birth_date' => '2010-08-03',
                'email' => 'diana@example.com',
                'average_score' => 4.55,
                'has_benefit' => true,
            ],
            [
                'id' => 7,
                'code' => 'PUP-007',
                'full_name' => 'Тлеубаев Нурлан',
                'school_class' => '11А',
                'birth_date' => '2009-12-17',
                'email' => 'nurlan@example.com',
                'average_score' => 4.30,
                'has_benefit' => false,
            ],
        ];
    }

    public function index(Request $request)
    {
        $pupils = collect($this->pupils());

        $search = $request->query('q');

        if ($search) {
            $pupils = $pupils->filter(
                fn ($pupil) =>
                    mb_stripos($pupil['full_name'], $search) !== false
            );
        }

        $sort = $request->query('sort', 'full_name');

        if (in_array(
            $sort,
            ['full_name', 'birth_date', 'average_score'],
            true
        )) {
            $pupils = $pupils->sortBy($sort);
        }

        return view('catalog.index', [
            'title' => 'Каталог учеников',
            'pupils' => $pupils,
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    public function show(int $id)
    {
        $pupil = collect($this->pupils())
            ->firstWhere('id', $id);

        abort_if(! $pupil, 404);

        return view('catalog.show', [
            'title' => $pupil['full_name'],
            'pupil' => $pupil,
        ]);
    }

    public function byCode(string $code)
    {
        $pupil = collect($this->pupils())
            ->firstWhere('code', $code);

        abort_if(! $pupil, 404);

        return view('catalog.show', [
            'title' => $pupil['full_name'],
            'pupil' => $pupil,
        ]);
    }

    public function bySchoolClass(?string $schoolClass = null)
    {
        $pupils = collect($this->pupils());

        if ($schoolClass === null) {
            $classes = $pupils
                ->pluck('school_class')
                ->unique()
                ->sort()
                ->values();

            return view('catalog.parents', [
                'title' => 'Школьные классы',
                'classes' => $classes,
            ]);
        }

        $pupils = $pupils->where(
            'school_class',
            $schoolClass
        );

        return view('catalog.index', [
            'title' => "Ученики класса {$schoolClass}",
            'pupils' => $pupils,
            'search' => null,
            'sort' => 'full_name',
        ]);
    }

    public function stats()
    {
        $pupils = collect($this->pupils());

        return view('catalog.stats', [
            'title' => 'Статистика учеников',
            'count' => $pupils->count(),
            'avg' => $pupils->avg('average_score'),
            'min' => $pupils->min('average_score'),
            'max' => $pupils->max('average_score'),
        ]);
    }
}