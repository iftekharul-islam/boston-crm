<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;

class LocalizationController extends Controller {
    public function __invoke($locale): RedirectResponse {
        $languages = array_keys(config('app.languages')) ?? [config('app.locale')];
        if (in_array($locale, $languages)) {
            App::setlocale($locale);
            session()->put('locale', $locale);
        }

        return redirect()->back();
    }

    /**
     * @param $locale
     *
     * @return RedirectResponse
     */
    public function index($locale): RedirectResponse {
    }
}
