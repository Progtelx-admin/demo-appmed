<?php

namespace App\Http\Controllers;

use App\Models\Language;

class HomeController extends Controller
{
    /**
     * change locale
     *
     * @var @locale
     */
    public function change_locale($locale)
    {
        $language = Language::where('iso', $locale)->first();

        session()->put('locale', $locale);
        session()->put('rtl', $language['rtl']);
        session()->forget('trans');

        return redirect()->back();
    }
}
