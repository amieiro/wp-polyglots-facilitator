<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordTranslation extends Model
{
    protected $table = 'word_translations';

    protected $fillable = [
        'source_locale_code',
        'destination_locale_code',
        'source_word',
        'destination_word'
    ];
}
