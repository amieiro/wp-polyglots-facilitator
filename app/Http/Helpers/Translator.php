<?php


namespace App\Http\Helpers;

// todo: put in an .env variable
ini_set('max_execution_time', 180);

use App\Http\Helpers\TranslationBlock;
use App\Models\WordTranslation;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class Translator
{
    protected $translationType;
    protected $translationFrom;
    protected $slug;
    protected $readme = null;
    protected $originalLanguage;
    protected $originalLanguageVariation;
    protected $destinationLanguage;
    protected $destinationLanguageVariation;
    protected $numberOfStrings;
    protected $translateStrings = null;

    protected $urlBase;
    protected $urlSourceLanguageFile;
    protected $sourceLanguageFile;
    protected $sourceLanguagePath;
    protected $fullSourceLanguagePath;
    protected $urlDestinationLanguageFile;
    protected $destinationLanguageFile;
    protected $destinationLanguagePath;
    protected $fullDestinationLanguagePath;

    protected $sourceCollection;
    protected $destinationCollection;

    public $error = null;
    public $fullOutcomePath;
    public $fileNameToReturn;

    /**
     * Create a new instance
     *
     * @param string $translationType
     * @param string $translationFrom
     * @param string $slug
     * @param boolean $readme
     * @param string $originalLanguage
     * @param string $originalLanguageVariation
     * @param string $destinationLanguage
     * @param string $destinationLanguageVariation
     * @param integer $numberOfStrings
     * @param boolean $translateStrings
     *
     */
    public function __construct($translationType, $translationFrom, $slug, $readme, $originalLanguage, $originalLanguageVariation, $destinationLanguage, $destinationLanguageVariation, $numberOfStrings, $translateStrings)
    {
        try {
            $this->translationType = $translationType;
            $this->translationFrom = $translationFrom;
            $this->slug = $slug;
            $this->readme = ($readme === 'on') ? '-readme' : '';
            $this->originalLanguage = $originalLanguage;
            $this->originalLanguageVariation = $originalLanguageVariation;
            $this->destinationLanguage = $destinationLanguage;
            $this->destinationLanguageVariation = $destinationLanguageVariation;
            $this->numberOfStrings = $numberOfStrings;
            $this->translateStrings = $translateStrings;
        } catch (Exception $exception) {
            $this->error = 'Error in the __construct method: ' . $exception->getMessage();
        }
    }


    /**
     * Main method for the class
     *
     * @throws Exception
     */
    public function translate()
    {
        try {
            // Download the files from wordpress.org
            $this->downloadPoFiles();

            // Load files into collections
            $this->sourceCollection = $this->createCollectionFromFile($this->fullSourceLanguagePath);
            $this->destinationCollection = $this->createCollectionFromFile($this->fullDestinationLanguagePath);

            // Replace destination language translations with original language strings
            $destinationCollection = $this->searchAndReplaceStrings($this->sourceCollection, $this->destinationCollection);

            if (($this->translateStrings === 'on') && ($this->originalLanguage === 'es') && ($this->destinationLanguage === 'gl')) {
                $destinationCollection = $this->replaceWordTRanslations($destinationCollection, 'es_ES', 'gl_ES');
            }

            // Save the resulting file
            $this->fullOutcomePath = $this->getFullOutcomePath();
            $this->fileNameToReturn = $this->getFileNameToReturn();
            $this->writeInDestinationFile($destinationCollection, $this->fullOutcomePath, $this->fullDestinationLanguagePath);
        } catch (Exception $exception) {
            if ($this->error === null) {
                $this->error = 'Error in the translate method: ' . $exception->getMessage();
            }
        }
    }

    /**
     * Download the source and destination .po files from wordpress.org to the local storage
     *
     * @throws Exception
     */
    protected
    function downloadPoFiles(): void
    {
        try {
            switch ($this->translationType) {
                case 'plugin':
                    $this->urlBase = 'https://translate.wordpress.org/projects/wp-plugins/';
                    $this->urlSourceLanguageFile = $this->urlBase . $this->slug . '/' . $this->translationFrom . $this->readme . '/' . $this->originalLanguage . '/' . $this->originalLanguageVariation . '/export-translations/';
                    $this->sourceLanguageFile = 'wp-plugins-' . $this->slug . '-' . $this->translationFrom . '-' . $this->originalLanguage . '-' . $this->originalLanguageVariation . '.po';
                    $this->urlDestinationLanguageFile = $this->urlBase . $this->slug . '/' . $this->translationFrom . $this->readme . '/' . $this->destinationLanguage . '/' . $this->destinationLanguageVariation . '/export-translations/?filters%5Bstatus%5D=untranslated';
                    $this->destinationLanguageFile = 'wp-plugins-' . $this->slug . '-' . $this->translationFrom . '-' . $this->destinationLanguage . '-' . $this->destinationLanguageVariation . '.po';
                    break;
                case 'theme':
                    $this->urlBase = 'https://translate.wordpress.org/projects/wp-themes/';
                    $this->urlSourceLanguageFile = $this->urlBase . $this->slug . '/' . $this->originalLanguage . '/' . $this->originalLanguageVariation . '/export-translations/';
                    $this->sourceLanguageFile = 'wp-themes-' . $this->slug . '-' . $this->originalLanguage . '-' . $this->originalLanguageVariation . '.po';
                    $this->urlDestinationLanguageFile = $this->urlBase . $this->slug . '/' . $this->destinationLanguage . '/' . $this->destinationLanguageVariation . '/export-translations/?filters%5Bstatus%5D=untranslated';
                    $this->destinationLanguageFile = 'wp-themes-' . $this->slug . '-' . $this->destinationLanguage . '-' . $this->destinationLanguageVariation . '.po';
                    break;
                case 'pattern':
                    $this->urlBase = 'https://translate.wordpress.org/projects/patterns/core/';
                    break;
                case 'wordpress-development':
                    $this->urlBase = 'https://translate.wordpress.org/projects/wp/dev/';
                    break;
                case 'wordpress-continents-cities':
                    $this->urlBase = 'https://translate.wordpress.org/projects/wp/dev/cc/';
                    break;
                case 'wordpress-administration':
                    $this->urlBase = 'https://translate.wordpress.org/projects/wp/dev/admin/';
                    break;
                case 'wordpress-network-admin':
                    $this->urlBase = 'https://translate.wordpress.org/projects/wp/dev/admin/network/';
                    break;
                case 'meta-wordcamp':
                    $this->urlBase = 'https://translate.wordpress.org/projects/meta/wordcamp/';
                    break;
                case 'meta-wordpress-org':
                    $this->urlBase = 'https://translate.wordpress.org/projects/meta/wordpress-org/';
                    break;
                case 'meta-wordpress-plugins-directory':
                    $this->urlBase = 'https://translate.wordpress.org/projects/meta/plugins-v3/';
                    break;
                case 'meta-forums':
                    $this->urlBase = 'https://translate.wordpress.org/projects/meta/forums/';
                    break;
                case 'meta-wordpress-theme-directory':
                    $this->urlBase = 'https://translate.wordpress.org/projects/meta/themes/';
                    break;
                case 'meta-o2':
                    $this->urlBase = 'https://translate.wordpress.org/projects/meta/o2/';
                    break;
                case 'meta-rosetta':
                    $this->urlBase = 'https://translate.wordpress.org/projects/meta/rosetta/';
                    break;
                case 'meta-p2-breathe':
                    $this->urlBase = 'https://translate.wordpress.org/projects/meta/p2-breathe/';
                    break;
                case 'meta-browse-happy':
                    $this->urlBase = 'https://translate.wordpress.org/projects/meta/browsehappy/';
                    break;
                case 'meta-get-involved':
                    $this->urlBase = 'https://translate.wordpress.org/projects/meta/get-involved/';
                    break;
                case 'meta-pattern-directory':
                    $this->urlBase = 'https://translate.wordpress.org/projects/meta/pattern-directory/';
                    break;
                case 'meta-learn-wordpress':
                    $this->urlBase = 'https://translate.wordpress.org/projects/meta/learn-wordpress/';
                    break;
                case 'meta-openverse':
                    $this->urlBase = 'https://translate.wordpress.org/projects/meta/openverse/';
                    break;
                case 'android':
                    $this->urlBase = 'https://translate.wordpress.org/projects/apps/android/dev/';
                    break;
                case 'ios':
                    $this->urlBase = 'https://translate.wordpress.org/projects/apps/ios/dev/';
                    break;
                case 'wpcom':
                    $this->urlBase = 'https://translate.wordpress.com/projects/wpcom/';
                    break;
                default:
            }
            if (!(($this->translationType === 'plugin') || ($this->translationType === 'theme'))) {
                $this->urlSourceLanguageFile = $this->urlBase . $this->originalLanguage . '/' . $this->originalLanguageVariation . '/export-translations/';
                $this->sourceLanguageFile = $this->translationType . '-' . $this->originalLanguage . '-' . $this->originalLanguageVariation . '.po';
                $this->urlDestinationLanguageFile = $this->urlBase . $this->destinationLanguage . '/' . $this->destinationLanguageVariation . '/export-translations/?filters%5Bstatus%5D=untranslated';
                $this->destinationLanguageFile = $this->translationType . '-' . $this->destinationLanguage . '-' . $this->destinationLanguageVariation . '.po';
            }
            $this->fullSourceLanguagePath = storage_path('app/' . $this->sourceLanguageFile);
            $this->sourceLanguagePath = 'app/' . $this->sourceLanguageFile;
            $this->destinationLanguagePath = 'app/' . $this->destinationLanguageFile;
            $this->fullDestinationLanguagePath = storage_path('app/' . $this->destinationLanguageFile);

            $fileHeadersSourceLanguageFile = @get_headers($this->urlSourceLanguageFile);
            $fileHeadersDestinationLanguageFile = @get_headers($this->urlDestinationLanguageFile);
            if ((strpos($fileHeadersSourceLanguageFile[0], '200', 0) !== false) && (strpos($fileHeadersDestinationLanguageFile[0], '200', 0) !== false)) {
	            ini_set('user_agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36');
	            file_put_contents(storage_path($this->sourceLanguagePath), fopen($this->urlSourceLanguageFile, 'r'));
                file_put_contents(storage_path($this->destinationLanguagePath), fopen($this->urlDestinationLanguageFile, 'r'));
            } elseif ( ! str_contains( $fileHeadersSourceLanguageFile[0], '200' ) ) {
                $this->error = 'Original file not found. URL: ' . $this->urlSourceLanguageFile . json_encode(get_headers($this->urlSourceLanguageFile));
                throw new Exception($this->error);
            }
        } catch (Exception $exception) {
            if ($this->error === null) {
                $this->error = 'Error in the downloadPoFiles method: ' . $exception->getMessage() ;
            }
            throw new Exception($this->error);
        }
    }

    /**
     * Create a collection from a .po file
     *
     * @param $archivo
     * @return Collection
     * @throws Exception
     */
    protected
    function createCollectionFromFile($archivo)
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
            $this->error = 'Error in the createCollectionFromFile method: ' . $exception->getMessage();
            throw new Exception($this->error);
        }
    }

    /**
     * Search the key string in the destination collection and replace the value
     * in this collection with the value from the original collection with the
     * same key
     *
     * @param Collection $originalCollection
     * @param Collection $destinationCollection
     * @return Collection
     * @throws Exception
     */
    protected
    function searchAndReplaceStrings(Collection $originalCollection, Collection $destinationCollection)
    {
	    $counter=0;
		$originalObject=null;
        try {
            $destinationCollection = $destinationCollection->sortBy(function ($value, $key) {
                return strlen($value->msgid);
            }, SORT_REGULAR, false);
            foreach ($destinationCollection as $key => $destinationObject) {
                $originalObject = $originalCollection->filter(function ($item) use ($destinationObject) {
                    return $item->msgid === $destinationObject->msgid;
                })->first();
                if (('' == $originalObject->msgstr) || (null == $originalObject->msgstr)) { // If the original doesn't have translation, skip this string.
                    $destinationCollection->forget($key);
                    continue;
                }
                $destinationObject->msgstr = $originalObject->msgstr;
                $destinationObject->msgstr0 = $originalObject->msgstr0;
                $destinationObject->msgstr1 = $originalObject->msgstr1;
                $counter++;
                if ($counter >= $this->numberOfStrings) { // Only process the number of strings required.
                    break;
                }
            }

           return $destinationCollection->take($this->numberOfStrings);
        } catch (Exception $exception) {
            $this->error = 'Error in the searchAndReplaceStrings method: ' . $exception->getMessage() . '<br>';
			$this->error .= 'Original object: ' . json_encode($originalObject) . '<br>';
            throw new Exception($this->error);
        }
    }

    /**
     * Replace words or short strings in a collection from an original language
     * to a destination language
     * These matches are stored in the "word_translations" table of the database
     *
     * @param Collection $collection
     * @param string $originalLanguage
     * @param string $destinationLanguage
     * @return Collection
     * @throws Exception
     */
    protected
    function replaceWordTRanslations(Collection $collection, string $originalLanguage, string $destinationLanguage)
    {
        try {
            $wordTRanslations = WordTranslation::where('source_locale_code', $originalLanguage)
                ->where('destination_locale_code', $destinationLanguage)
                ->get();
            foreach ($collection as $translationBlock) {
                if ($translationBlock->msgstr !== null && (trim($translationBlock->msgstr) !== '')) {
                    $translationBlock->comment .= PHP_EOL . '# Original translation (msgstr) in "' . $this->originalLanguage . '" language is: "' . $translationBlock->msgstr . '"';
                    foreach ($wordTRanslations as $word) {
                        $translationBlock->msgstr = preg_replace('/\b' . trim($word->source_word) . '\b/u', trim($word->destination_word), $translationBlock->msgstr);
                        $translationBlock->msgstr = preg_replace('/\b' . ucfirst(trim($word->source_word)) . '\b/u', ucfirst(trim($word->destination_word)), $translationBlock->msgstr);
                        $translationBlock->msgstr = preg_replace('/\b' . strtoupper(trim($word->source_word)) . '\b/u', strtoupper(trim($word->destination_word)), $translationBlock->msgstr);
                    }
                }
                if ($translationBlock->msgstr0 !== null && (trim($translationBlock->msgstr0) !== '')) {
                    $translationBlock->comment .= PHP_EOL . '# Original translation (msgstr[0]) in "' . $this->originalLanguage . '" language is: ' . $translationBlock->msgstr0 . '"';
                    foreach ($wordTRanslations as $word) {
                        $translationBlock->msgstr0 = preg_replace('/\b' . trim($word->source_word) . '\b/u', trim($word->destination_word), $translationBlock->msgstr0);
                        $translationBlock->msgstr0 = preg_replace('/\b' . ucfirst(trim($word->source_word)) . '\b/u', ucfirst(trim($word->destination_word)), $translationBlock->msgstr0);
                        $translationBlock->msgstr0 = preg_replace('/\b' . strtoupper(trim($word->source_word)) . '\b/u', strtoupper(trim($word->destination_word)), $translationBlock->msgstr0);
                    }
                }
                if ($translationBlock->msgstr1 !== null && (trim($translationBlock->msgstr1) !== '')) {
                    $translationBlock->comment .= PHP_EOL . '# Original translation (msgstr[1]) in "' . $this->originalLanguage . '" language is: ' . $translationBlock->msgstr1 . '"';
                    foreach ($wordTRanslations as $word) {
                        $translationBlock->msgstr1 = preg_replace('/\b' . trim($word->source_word) . '\b/u', trim($word->destination_word), $translationBlock->msgstr1);
                        $translationBlock->msgstr1 = preg_replace('/\b' . ucfirst(trim($word->source_word)) . '\b/u', ucfirst(trim($word->destination_word)), $translationBlock->msgstr1);
                        $translationBlock->msgstr1 = preg_replace('/\b' . strtoupper(trim($word->source_word)) . '\b/u', strtoupper(trim($word->destination_word)), $translationBlock->msgstr1);
                    }
                }
            }
            return $collection;

        } catch (Exception $exception) {
            $this->error = 'Error in the replaceWordTRanslations method: ' . $exception->getMessage();
            throw new Exception($this->error);
        }
    }

    /**
     * Write the collection in the outcome file
     *
     * @param Collection $destinationCollection
     * @param string $fullOutcomePath
     * @param string $fullDestinationLanguagePath
     */
    protected
    function writeInDestinationFile(Collection $destinationCollection, string $fullOutcomePath, string $fullDestinationLanguagePath): void
    {
        $poToExport = '';
        // Copy the first 13 lines from the destination language to the
        // outcome path
        $numberOfLinesInHeaderFile = 13;
        $fileContent = File::get($fullDestinationLanguagePath);
        $rows = explode("\n", $fileContent);
        foreach ($rows as $row) {
            $numberOfLinesInHeaderFile--;
            $poToExport .= $row . PHP_EOL;
            if ($numberOfLinesInHeaderFile <= 0) {
                break;
            }
        }

        foreach ($destinationCollection as $destinationObject) {
            if (($destinationObject->msgid === null) || ($destinationObject->msgid === '')) {
                continue;
            }
            if ($destinationObject->comment !== null) {
                $poToExport .= $destinationObject->comment . PHP_EOL;
            }
            if ($destinationObject->msgctxt !== null) {
                $poToExport .= 'msgctxt ' . '"' . $destinationObject->msgctxt . '"' . PHP_EOL;
            }
            if ($destinationObject->msgid !== null) {
                $poToExport .= 'msgid ' . '"' . $destinationObject->msgid . '"' . PHP_EOL;
            }
            if ($destinationObject->msgid_plural !== null) {
                $poToExport .= 'msgid_plural ' . '"' . $destinationObject->msgid_plural . '"' . PHP_EOL;
            }
            if (($destinationObject->msgstr !== null) && (trim($destinationObject->msgstr) !== '')) {
                $poToExport .= 'msgstr ' . '"' . $destinationObject->msgstr . '"' . PHP_EOL;
            }
            if ($destinationObject->msgstr0 !== null) {
                $poToExport .= 'msgstr[0] ' . '"' . $destinationObject->msgstr0 . '"' . PHP_EOL;
            }
            if ($destinationObject->msgstr1 !== null) {
                $poToExport .= 'msgstr[1] ' . '"' . $destinationObject->msgstr1 . '"' . PHP_EOL;
            }
            $poToExport .= PHP_EOL;

            $this->numberOfStrings--;
            if ($this->numberOfStrings === 0) break;
        }
        File::put($fullOutcomePath, $poToExport);
    }


    /**
     * Remove the first and last quote from a quoted string of text
     * https://stackoverflow.com/questions/9734758/remove-quotes-from-start-and-end-of-string-in-php
     *
     * @param mixed $text
     * @return mixed $text
     */
    protected
    function stripQuotes($text)
    {
        return preg_replace('/^(\'(.*)\'|"(.*)")$/', '$2$3', $text);
    }

    protected function getFullOutcomePath()
    {
        switch ($this->translationType) {
            case 'plugin':
            case 'theme':
                return storage_path('app/' . $this->slug . '-' . $this->originalLanguage . '-' . $this->destinationLanguage . '-' . random_int(0, PHP_INT_MAX) . '.po');
            default:
                return storage_path('app/' . $this->translationType . '-' . $this->originalLanguage . '-' . $this->destinationLanguage . '-' . random_int(0, PHP_INT_MAX) . '.po');
        }
    }

    protected function getFileNameToReturn()
    {
        switch ($this->translationType) {
            case 'plugin':
            case 'theme':
                return $this->slug . '-' . $this->destinationLanguage . '.po';
            default:
                return $this->translationType . '-' . $this->destinationLanguage . '.po';
        }

    }
}
