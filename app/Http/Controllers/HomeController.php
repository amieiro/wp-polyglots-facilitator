<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Locale;
use App\Models\WordTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): View
    {
        $locales = Locale::orderBy('locale_name', 'ASC')->pluck('locale_name', 'locale_code');
        $variations = ['default', 'a090', 'formal', 'informal', 'valencia'];
        return view('index', compact('locales', 'variations'));
    }

    /**
     * Update the locale session variable and the app locale
     */
    public function language(Request $request, string $language): RedirectResponse
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

    public function localeChange(Request $request): JsonResponse
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
