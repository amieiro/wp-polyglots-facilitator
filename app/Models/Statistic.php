<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $fillable = [
        'type',
        'locale_code',
        'counter',
        'percent',
        'number_contributors',
        'translated',
        'untranslated',
        'fuzzy',
        'waiting',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'counter' => 'integer',
            'percent' => 'float',
            'number_contributors' => 'integer',
            'translated' => 'integer',
            'untranslated' => 'integer',
            'fuzzy' => 'integer',
            'waiting' => 'integer',
        ];
    }
}
