<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PupilApiRequest;
use App\Http\Resources\PupilResource;
use App\Models\Pupil;
use App\Support\ApiFormat;
use Illuminate\Http\Request;

class PupilController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'sort' => [
                'sometimes',
                'in:full_name,-full_name,average_score,-average_score',
            ],

            'per_page' => [
                'sometimes',
                'integer',
                'between:1,50',
            ],
        ]);

        $query = Pupil::with('schoolClass');

        if ($request->filled('q')) {
            $query->where(
                'full_name',
                'like',
                '%' . $request->query('q') . '%'
            );
        }

        $sort = $request->query('sort');

        if ($sort) {
            $query->orderBy(
                ltrim($sort, '-'),
                str_starts_with($sort, '-')
                    ? 'desc'
                    : 'asc'
            );
        } else {
            $query->orderBy('full_name');
        }

        $pupils = $query->paginate(
            $request->integer('per_page', 4)
        );

        return ApiFormat::success(
            PupilResource::collection($pupils),
            200,
            [
                'pagination' => [
                    'page' => $pupils->currentPage(),
                    'pages' => $pupils->lastPage(),
                    'limit' => $pupils->perPage(),
                    'count' => $pupils->total(),
                ],
            ]
        );
    }

    public function store(PupilApiRequest $request)
    {
        $pupil = Pupil::create(
            $request->validated()
        )->load('schoolClass');

        return ApiFormat::success(
            new PupilResource($pupil),
            201
        )->header(
            'Location',
            route('api.pupils.show', $pupil)
        );
    }

    public function show(Pupil $pupil)
    {
        return ApiFormat::success(
            new PupilResource(
                $pupil->load('schoolClass')
            )
        );
    }

    public function update(
        PupilApiRequest $request,
        Pupil $pupil
    ) {
        $pupil->update(
            $request->validated()
        );

        return ApiFormat::success(
            new PupilResource(
                $pupil->load('schoolClass')
            )
        );
    }

    public function destroy(Pupil $pupil)
    {
        $pupil->delete();

        return response()->noContent();
    }
}