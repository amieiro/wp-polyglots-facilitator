<?php

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
}
