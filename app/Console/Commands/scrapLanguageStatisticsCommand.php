<?php

namespace App\Console\Commands;

use App\Models\Locale;
use App\Models\Statistic;
use Goutte\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class scrapLanguageStatisticsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wp-translation:scrap-language-statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap Language Statistics';

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
     * @throws \Exception
     */
    public function handle()
    {
        $this->countPercentageAndContributors();
        $this->countCompleteElements('plugins');
        $this->countCompleteElements('themes');
    }


    /**
     * Count and store the themes or plugins completed in each locale
     *
     * @param string $locale_code
     * @param string $type
     */
    protected function countCompleteElements(string $type): void
    {
        try {
            $this->alert(__('Start the count of complete elements for ') . $type);
            $languages = Locale::inRandomOrder('locale_code')->get();
            foreach ($languages as $language) {
                $url = 'https://translate.wordpress.org/locale/' . $language->locale_code . '/default/stats/' . $type . '/';
                $client = new Client();
                $crawler = $client->request('GET', $url);
                $pluginsCompleted = $crawler->filter('[data-column-title="Untranslated"]')->filter('[data-sort-value="0"]')->count();
                $statistic = Statistic::create([
                    'type' => $type,
                    'locale_code' => $language->locale_code,
                    'counter' => $pluginsCompleted,
                ]);
                $outputString = $statistic->type . ' - ' . $statistic->locale_code . ' - ' . $statistic->counter;
                $this->info($outputString);
                Log::info($outputString);
                sleep(random_int(10, 20));
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
            Log::error($exception->getMessage());
        }
    }

    /**
     * Count and store the WordPress core translated percentage and the number
     * of contributors in each locale
     *
     */
    protected function countPercentageAndContributors(): void
    {
        try {
            $this->alert(__('Start the WordPress core translated percentage and the number of contributors in each locale'));
            $client = new Client();
            $crawler = $client->request('GET', 'https://translate.wordpress.org/');
            $crawler->filter('div.locale')->each(function ($node) {
                $localeCode = substr(trim($node->filter('div.locale-button > a.button.contribute-button')->attr('href')), 8, -1);
                $numberContributors = trim($node->filter('div.contributors')->text());
                $client2 = new Client();
                $crawler2 = $client2->request('GET', 'https://translate.wordpress.org/locale/' . $localeCode . '/default/wp/');
                $percentage = $crawler2->filter('div.project-status')->filter('div.project-status-progress')->filter('span.project-status-value')->first()->text();
                $percentage = substr($percentage, 0, -1);
                $statistic = Statistic::create([
                    'type' => 'wordpress',
                    'locale_code' => $localeCode,
                    'percent' => $percentage,
                    'number_contributors' => $numberContributors,
                ]);
                $outputString = $statistic->type . ' - ' . $statistic->locale_code . ' - ' . $statistic->percent . ' - ' . $statistic->number_contributors;
                $this->info($outputString);
                Log::info($outputString);
                sleep(random_int(10, 20));
            });
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
            Log::error($exception->getMessage());
        }
    }
}
