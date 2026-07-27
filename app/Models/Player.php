<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'nama',
        'usia',
        'jenjang',
        'gender',
        'score',
        'duration',
        'is_finish',
    ];

    protected $attributes = [
        'score' => 0,
        'duration' => 0.0,
        'is_finish' => false,
    ];

    protected function casts(): array
    {
        return [
            'usia' => 'integer',
            'score' => 'integer',
            'duration' => 'float',
            'is_finish' => 'boolean',
        ];
    }
}
