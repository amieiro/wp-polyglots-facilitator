<?php

namespace App\Console\Commands;

use App\Imports\WordTranslationsImport;
use App\Models\WordTranslation;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class importWordTranslationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wp-translation:import-word-translation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate the "word_translations" table and import the translations between two languages from an ODS file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = base_path('storage/app/vocabulary/wordTranslation/es_ES-gl_ES.ods');
        WordTranslation::query()->truncate();
        Excel::import(new WordTranslationsImport, $file);
    }
}
