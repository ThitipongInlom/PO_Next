<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function pageProfile(Request $request)
    {
        return view('page/profile');
    }

}