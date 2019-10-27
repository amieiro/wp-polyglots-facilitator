<?php

namespace App\Http\Controllers;

use App\Models\Locale;
use App\Models\WordTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Session;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $locales = Locale::orderBy('locale_name', 'ASC')->pluck('locale_name', 'locale_code');
        return view('index', compact('locales'));
    }

    /**
     * Update the locale session variable and the app locale
     *
     * @param Request $request
     * @param string $language
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function language(Request $request, string $language)
    {
        try {
            if (array_key_exists($language, config('locale.languages'))) {
                Session::put('locale', $language);
                App::setLocale($language);
                return redirect()->back();
            }
            return redirect('/');
        } catch (\Exception $exception) {
            return redirect('/');
        }
    }

    public function localeChange(Request $request)
    {
        if($request->ajax()) {
            try {
                $sourceLocaleCode = Locale::where('locale_code', $request['originalLanguage'])->first()->wordpress_locale;
                $destinationLocaleCode = Locale::where('locale_code', $request['destinationLanguage'])->first()->wordpress_locale;
                $occurrences = WordTranslation::where('source_locale_code', $sourceLocaleCode)
                    ->where('destination_locale_code', $destinationLocaleCode)->count();
                return response()->json($occurrences);
            } catch (\Exception $exception) {
                return response()->json(0);
            }
        } else {
            return response()->json(0);
        }
    }
}
