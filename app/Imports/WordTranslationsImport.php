<?php

namespace App\Imports;

use App\Models\WordTranslation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WordTranslationsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new WordTranslation([
            'source_locale_code' => 'es_ES',
            'destination_locale_code' => 'gl_ES',
            'source_word' => $row['es_es'],
            'destination_word' => $row['gl_es']
        ]);
    }
}
