<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\user;

class FunctionController extends Controller
{
    // Action
    public static function lineNotify($token, $message)
    {
        $response = Http::asForm()->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->post('https://notify-api.line.me/api/notify', [
            'message' => $message
        ]);
    }

    public function submitOnlineUser(Request $request)
    {
        user::where('user_id', Auth::user()->user_id)->update([
            'last_active' => Carbon::now()
        ]);

        return response()->json([
            'message' => 'อัพเดตเวลาล่าสุด สำเร็จ'
        ], 200);    
    }

}