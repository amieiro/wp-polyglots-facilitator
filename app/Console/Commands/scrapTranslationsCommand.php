<?php

namespace App\Console\Commands;

use App\Http\Helpers\TranslationBlock;
use App\Models\Translation;
use Exception;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class scrapTranslationsCommand extends Command
{
    protected string $urlBase = 'https://translate.wordpress.org/api/projects/';

    protected string $urlBaseThemes = 'https://translate.wordpress.org/api/projects/wp-themes/';

    protected string $type;

    protected string $locale;

    protected int $minWait;

    protected int $maxWait;

    protected bool $downloadAll;

    protected bool $deletePo;

    protected bool $showStats;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wp-translation:scrap-translations
            {--type=themes : The download type: currently, only themes}
            {--locale=es : The language selected for the downloads}
            {--minWait=0 : The minimum waiting time between two calls to translate.wordpress.org}
            {--maxWait=0 : The maximum waiting time between two calls to translate.wordpress.org}
            {--downloadAll : Download processed and not processed items (themes or plugins) for a language}
            {--deletePo : Delete the .po files after its usage}
            {--showStats : Show string stats, instead of downloading the translation files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap the translations for some WordPress items: plugins, themes,...Currently, only works with themes';

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
     * @return void
     */
    public function handle()
    {

        $this->type = $this->option('type');
        $this->locale = $this->option('locale');
        $this->minWait = $this->option('minWait');
        $this->maxWait = $this->option('maxWait');
        $this->downloadAll = $this->option('downloadAll');
        $this->deletePo = $this->option('deletePo');
        $this->showStats = $this->option('showStats');

        if ($this->showStats === true) {
            $this->printStats();
            exit();
        }

        $this->warn('Starting the scrap.');
        $themes = $this->get_themes_list();
        $this->warn('Downloading the translation of ' . count($themes) . ' themes.');
        foreach ($themes as $theme) {
            if ($this->downloadAll === false) {
                if ($this->is_theme_downloaded($theme, $this->locale)) {
                    $this->warn('The ' . $theme['slug'] . ' theme is downloaded in ' . $this->locale . ' locale. Skyping.');
                    continue;
                }
            }
            $filePath = $this->download_theme_translation($theme['slug'], $this->locale);
            $collection = $this->createCollectionFromFile($filePath);
            $this->persistCollection('theme', $theme['slug'], 'es', $collection);
            if ($this->deletePo === true) {
                unlink($filePath);
            }
            if (($this->minWait > 0) && ($this->maxWait > 0)) {
                sleep(rand($this->argument('minWait'), $this->argument('maxWait')));
            }
        }
    }

    /**
     * Get the theme list from the public API.
     *
     * @return array
     */
    private function get_themes_list(): array
    {
        $client = new Client();
        $request = $client->get($this->urlBaseThemes);
        return json_decode($request->getBody(), true)['sub_projects'];
    }

    /**
     * Download the .po file for a theme
     *
     * @param string $slug
     * @param string $language
     * @return string
     */
    private function download_theme_translation(string $slug, string $language): string
    {
        $this->warn('Downloading the "' . $slug . '" theme in "' . $language . '" language.');
        $client = new Client();
        $uri = 'https://translate.wordpress.org/projects/wp-themes/' . $slug . '/' . $language;
        $uri .= '/default/export-translations/?filters%5Bstatus%5D=current_or_waiting_or_fuzzy_or_untranslated';
        $sink = 'storage/app/downloads/themes/' . $language . '-' . $slug . '.po';
        $request = $client->get($uri, ['sink' => $sink]);
        return $sink;
    }

    /**
     * Check if the $theme is downloaded and stored in the database for the $locale
     *
     * @param array $theme
     * @param string $locale
     * @return bool
     */
    protected function is_theme_downloaded(array $theme, string $locale): bool
    {
        $is_downloaded = Translation::where('project_type', 'theme')
            ->where('project_slug', $theme['slug'])
            ->where('locale', $locale)
            ->first();
        return !empty($is_downloaded);
    }

    /**
     * Create a collection of TranslationBlock for the downloaded file
     *
     * @param $archivo
     * @return Collection|null
     */
    protected function createCollectionFromFile($archivo): ?Collection
    {
        try {
            $fileContent = File::get($archivo);
            $rows = explode("\n", $fileContent);
            $coleccion = new Collection();
            $myTranslationBlock = new TranslationBlock();
            // Iterate the array from the header, from line 13
            foreach (array_slice($rows, 13) as $row) {
                // Instantiate the new block with each empty line
                if (trim($row) === '') {
                    $coleccion->push($myTranslationBlock);
                    $myTranslationBlock = new TranslationBlock();
                }
                // Comment
                if (strpos($row, '#') === 0) {
                    $myTranslationBlock->comment .= $myTranslationBlock->comment === null ? $row : PHP_EOL . $row;
                    continue;
                }
                // msgctxt: Message context
                if (strpos($row, 'msgctxt') === 0) {
                    $myTranslationBlock->msgctxt = trim(substr($row, 8), '"') === '' ? null : $this->stripQuotes(substr($row, 8));
                    continue;
                }
                // msgid
                if (strpos($row, 'msgid ') === 0) {
                    $myTranslationBlock->msgid = $this->stripQuotes(substr($row, 6));
                    continue;
                }
                // msgid_plural
                if (strpos($row, 'msgid_plural') === 0) {
                    $myTranslationBlock->msgid_plural = $this->stripQuotes(substr($row, 13));
                    continue;
                }
                // msgstr
                if (strpos($row, 'msgstr ') === 0) {
                    $myTranslationBlock->msgstr = trim(substr($row, 7), '"') === '' ? null : $this->stripQuotes(substr($row, 7));
                    continue;
                }
                // msgstr[0]
                if (strpos($row, 'msgstr[0]') === 0) {
                    $myTranslationBlock->msgstr0 = trim(substr($row, 10), '"') === '' ? null : $this->stripQuotes(substr($row, 10));
                    continue;
                }
                // msgstr[1]
                if (strpos($row, 'msgstr[1]') === 0) {
                    $myTranslationBlock->msgstr1 = trim(substr($row, 10), '"') === '' ? null : $this->stripQuotes(substr($row, 10));
                    continue;
                }
            }
            // Add the last element to the collection
            $coleccion->push($myTranslationBlock);
            return $coleccion;
        } catch (Exception $exception) {
            $this->error('Error in the createCollectionFromFile method: ' . $exception->getMessage());
            return null;
        }
    }

    /**
     * Stores the TranslationBlock collection in the database
     *
     * @param string $project_type
     * @param string $project_slug
     * @param string $locale
     * @param Collection $collection
     * @return void
     */
    protected function persistCollection(string $project_type, string $project_slug, string $locale, Collection $collection)
    {
        foreach ($collection as $item) {
            try {
            Translation::updateOrCreate(
                [
                    'project_type' => $project_type,
                    'project_slug' => $project_slug,
                    'locale' => $locale,
                    'msgid' => $item->msgid,
                    'msgid_plural' => $item->msgid_plural,
                ],
                [
                    'comment' => $item->comment,
                    'msgctxt' => $item->msgctxt,
                    'msgstr' => $item->msgstr,
                    'msgstr0' => $item->msgstr0,
                    'msgstr1' => $item->msgstr1,
                ]
            );
            } catch (Exception $exception) {
                $this->error('Error in the createCollectionFromFile method: ' . $exception->getMessage());
                continue;
            }
        }
    }

    /**
     * Remove the first and last quote from a quoted string of text
     * https://stackoverflow.com/questions/9734758/remove-quotes-from-start-and-end-of-string-in-php
     *
     * @param mixed $text
     * @return mixed $text
     */
    protected function stripQuotes(mixed $text): mixed
    {
        return preg_replace('/^(\'(.*)\'|"(.*)")$/', '$2$3', $text);
    }

    protected function printStats() {
        $differentStringsNumber = DB::select('select COUNT(distinct(msgid)) as number from translations')[0]->number;
        echo 'Number of different strings: ' . $differentStringsNumber . PHP_EOL;
        $totalStringNumber = DB::select('select COUNT(msgid) as number from translations')[0]->number;
        echo 'Number of total strings: ' . $totalStringNumber . PHP_EOL;
        $stringsTranslatedNumber = DB::select('select COUNT(msgid) as number from translations where msgstr  IS NOT NULL')[0]->number;
        echo 'Number of strings translated: ' . $stringsTranslatedNumber . PHP_EOL;
        $percentage = number_format(($stringsTranslatedNumber/$totalStringNumber)*100, 2);
        echo "$percentage % of strings translated." . PHP_EOL;
        exit();

        //select sum(t_count.number) from (select COUNT(*) as number, msgid, msgstr from translations group by `msgid`, `msgstr` having COUNT(*)>10 order by msgid DESC) as t_count;
        // select COUNT(*) as number, msgid, msgstr from translations group by `msgid`, `msgstr` having COUNT(*)>10 order by msgid DESC
        $translations = DB::select(DB::raw('select COUNT(*) as number, msgid, msgstr from translations group by msgid, msgstr having COUNT(*)>10 order by number DESC'));
        foreach ($translations as $key => $translation) {
            echo $key . PHP_EOL;
            echo $translation->number . ': ' . $translation->msgid . ' -> ' . $translation->msgstr . PHP_EOL;
            if ($key > 10) exit();
        }
    }

}

