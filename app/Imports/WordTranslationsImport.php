<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\WordTranslation;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WordTranslationsImport implements ToModel, WithHeadingRow
{
    /**
     * Transform a row into a model.
     *
     * @param array<string, mixed> $row
     */
    public function model(array $row): ?Model
    {
        return new WordTranslation([
            'source_locale_code' => 'es_ES',
            'destination_locale_code' => 'gl_ES',
            'source_word' => $row['es_es'],
            'destination_word' => $row['gl_es']
        ]);
    }
}
