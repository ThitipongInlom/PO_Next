<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!empty(Auth::user()->language)) {
            App::setlocale(Auth::user()->language);
        }else {
            App::setlocale('th');
        }
        Cache::has('translations') ? Cache::pull('translations') : "";
        $filesLang = glob(resource_path('lang/'.App::getLocale().'/*.php'));
        $strings = [];
        foreach ($filesLang as $file) {
            $name = basename($file, '.php');
            $strings[$name] = require $file;
        }
        Cache::rememberForever('translations', function () use($strings) {
            return json_encode($strings);
        });

        return $next($request);
    }
}
