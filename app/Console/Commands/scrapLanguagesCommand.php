<?php

namespace App\Console\Commands;

use App\Models\Locale;
use Goutte\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class scrapLanguagesCommand extends Command
{
    protected $urlBase = 'https://translate.wordpress.org/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wp-translation:scrap-languages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap and store in the database the languages from https://translate.wordpress.org';

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
        try {
            // Check if the "locales" table is empty
            $locale = Locale::all();
            if (!$locale->isEmpty() && !$this->confirm(__('The database is not empty. All the values will be erased. Do you want to continue?'))) {
                exit();
            }
            $this->warn('Starting the scrap.');
            $client = new Client();
            $crawler = $client->request('GET', $this->urlBase);
            Locale::query()->truncate();
            $crawler->filter('div.locale')->each(function ($node) {
                $locale = Locale::create([
                    'locale_name' => trim($node->filter('ul.name > li.english')->text()),
                    'native_name' => trim($node->filter('ul.name > li.native')->text()),
                    'locale_code' => substr(trim($node->filter('div.locale-button > a.button.contribute-button')->attr('href')), 8, -1),
                    'wordpress_locale' => trim($node->filter('ul.name > li.code')->text())
                ]);
                $outputString = $locale->locale_name . ' - ' . $locale->native_name . ' - ' . $locale->locale_code . ' - ' . $locale->wordpress_locale;
                $this->info($outputString);
                Log::info($outputString);
            });
            $this->warn('Scrap finished.');
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
            Log::error($exception->getMessage());
        }
    }
}
