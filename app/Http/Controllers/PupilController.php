<?php

namespace App\Http\Controllers;

use App\Models\Pupil;
use Illuminate\Http\Request;
use App\Models\SchoolClass;


class PupilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pupil $pupil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pupil $pupil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pupil $pupil)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pupil $pupil)
    {
        //
    }
}
