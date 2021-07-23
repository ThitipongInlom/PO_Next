<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\user;

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
            user::where('user_id', Auth::user()->user_id)->update([
                'last_active' => Carbon::now()
            ]);
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
