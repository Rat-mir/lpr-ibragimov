<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\PupilController;

Route::get('/hello/{name?}', function (string $name = 'гость') {
    return "Привет, {$name}!";
})->where('name', '[\p{L}]+');


use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PageController;

Route::get('/', fn () =>
    redirect()->route('catalog.index')
);

Route::prefix('catalog')
    ->name('catalog.')
    ->controller(CatalogController::class)
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');

        Route::get('/stats', 'stats')
            ->name('stats');

        Route::get('/school-class/{schoolClass?}', 'bySchoolClass')
            ->name('school-class');

        Route::get('/code/{code}', 'byCode')
            ->where('code', '[A-Z]{3}-[0-9]{3}')
            ->name('code');

        Route::get('/{id}', 'show')
            ->whereNumber('id')
            ->name('show');
    });

    Route::resource('pupils', PupilController::class)
    ->except(['show']);
    Route::get(
    '/school-classes',
    [SchoolClassController::class, 'index']
)->name('school-classes.index');

Route::delete(
    '/school-classes/{schoolClass}',
    [SchoolClassController::class, 'destroy']
)->name('school-classes.destroy');

Route::get(
    '/feedback',
    [PageController::class, 'feedbackForm']
)->name('feedback.form');

Route::post(
    '/feedback',
    [PageController::class, 'feedbackSend']
)->name('feedback.send');