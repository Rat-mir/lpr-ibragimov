<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Club extends Model
{
    protected $fillable = [
        'name',
    ];

    public function pupils(): BelongsToMany
    {
        return $this->belongsToMany(
            Pupil::class
        );
    }
}