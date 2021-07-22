<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
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
        if (!empty(Auth::user()->lang)) {
            App::setlocale(Auth::user()->lang);
        }else {
            App::setlocale('en');
        }
        $langPath = resource_path('lang/'.App::getLocale());
        collect(Storage::files($langPath))->flatMap(function($file) {
            dump($file);
            return [
                $translation = $file->getBasename('.php') => trans($translation),
            ];
        } )->toJson();

        return $next($request);
    }
}
