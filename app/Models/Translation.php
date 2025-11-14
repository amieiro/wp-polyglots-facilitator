<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = [
        'project_type',
        'project_slug',
        'locale',
        'comment',
        'msgctxt',
        'msgid',
        'msgid_plural',
        'msgstr',
        'msgstr0',
        'msgstr1',
    ];
}
