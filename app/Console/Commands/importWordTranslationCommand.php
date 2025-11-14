<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Imports\WordTranslationsImport;
use App\Models\WordTranslation;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class importWordTranslationCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'wp-translation:import-word-translation';

    /**
     * The console command description.
     */
    protected $description = 'Truncate the "word_translations" table and import all translations between two languages from an ODS file';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $file = base_path('storage/app/vocabulary/wordTranslation/es_ES-gl_ES.ods');
        WordTranslation::query()->truncate();
        Excel::import(new WordTranslationsImport, $file);
    }
}
