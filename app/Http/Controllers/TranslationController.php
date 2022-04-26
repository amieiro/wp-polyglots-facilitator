<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Translator;
use App\Http\Requests\DownloadAndReplaceTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TranslationController extends Controller
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

    protected function downloadAndReplace(DownloadAndReplaceTranslation $request)
    {
        $request->session()->put('translationRequest', $request->except('_token', 'download-po'));
        // Request validation
        $validator = Validator::make($request->all(), [
            'translationType' => 'required',
            'translationFrom' => 'required',
            'originalLanguage' => 'required',
            'originalLanguageVariation' => 'required',
            'destinationLanguage' => 'required',
            'destinationLanguageVariation' => 'required',
            'numberOfStrings' => 'required|integer|min:1|max:1000000'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $this->translationType = $request->translationType;
            $this->translationFrom = $request->translationFrom;
            $this->slug = $request->slug;
            $this->readme = $request->readme;
            $this->originalLanguage = $request->originalLanguage;
            $this->originalLanguageVariation = $request->originalLanguageVariation;
            $this->destinationLanguage = $request->destinationLanguage;
            $this->destinationLanguageVariation = $request->destinationLanguageVariation;
            $this->numberOfStrings = $request->numberOfStrings;
            $this->translateStrings = $request->translateStrings;
            $translator = new Translator(
				$this->translationType,
				$this->translationFrom,
				$this->slug,
				$this->readme,
				$this->originalLanguage,
				$this->originalLanguageVariation,
				$this->destinationLanguage,
				$this->destinationLanguageVariation,
				$this->numberOfStrings,
				$this->translateStrings
            );
            $translator->translate();
            if ($translator->error === null) {
                return response()->download($translator->fullOutcomePath, $translator->fileNameToReturn);
            }
            $validator->errors()->add('global-errors', $translator->error);
            return redirect()->back()->withErrors($validator)->withInput();
        } catch (\Exception $exception) {
            echo $exception;
        }
    }
}
