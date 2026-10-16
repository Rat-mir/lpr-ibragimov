<?php

namespace Database\Seeders;

use App\Models\Pupil;
use App\Models\SchoolClass;
use App\Models\Club;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $classes = SchoolClass::factory()
            ->count(5)
            ->create();

        Pupil::factory()
            ->count(17)
            ->recycle($classes)
            ->create();

        $clubs = collect([
            'Робототехника',
            'Шахматы',
            'Футбол',
            'Рисование',
            'Программирование',
        ]);

        foreach ($clubs as $clubName) {
            Club::firstOrCreate([
                'name' => $clubName,
            ]);
        }
    }
}