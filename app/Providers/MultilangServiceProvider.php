<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Config;
use Request;
use App;

class MultilangServiceProvider extends ServiceProvider {
    public function boot() {
        $this->setLang();
    }

    public function setLang(){
        $enable_multilang = Config::get('app.multilang');
        if ($enable_multilang) {
            $language = Request::segment(1);
            $routeLang = '';
            if (isset(config('app.locales')[$language])) {
                App::setLocale($language);
                $routeLang = $language;
            }
            Config::set('app.routeLang', $routeLang);
        }
    }

}
