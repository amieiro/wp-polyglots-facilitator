<?php

namespace App\Http\Controllers;

use App\Models\Locale;
use Illuminate\Http\Request;

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
}
