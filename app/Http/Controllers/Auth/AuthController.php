<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\user;

class AuthController extends Controller
{
    // Page
    public function pageLogin(Request $request)
    {   
        $urlImageBackgroundIogin = url(Storage::url("assets/static/image/background_login.jpg"));

        return view('auth/login', [
            'urlImageBackgroundIogin' => $urlImageBackgroundIogin
        ]);
    }

    // Action
    public function submitLogin(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $customMessages = [
            'required' => 'ไม่พบข้อมูล :attribute'
        ];

        $validation = Validator::make($request->all(), $rules, $customMessages);
        if ($validation->fails()) {
            return response()->json([
                'message' => 'เกิดข้อผิดพลาดในการส่งข้อมูลไม่ครบตามที่กำหนดไว้',
                'error' => $validation->errors()
            ], 400); 
        }
        
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // เช็คว่าถูก ให้เข้าใช้งานได้หรือไม่
            if (Auth::user()->status == '0') {
                Auth::logout();
                return response()->json([
                    'message' => 'Username ไม่สามารถเข้าใช้งานได้'
                ], 400);
            }
            // อัพเดต หลังจาก Login สำเร็จ
            user::where('user_id', Auth::user()->user_id)->update([
                'ip_address' => $request->ip(),
                'device' => $request->device,
                'last_active' => Carbon::now()
            ]);

            return response()->json([
                'message' => 'เข้าสู่ระบบสำเร็จ กรุณารอซักครู่'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Username หรือ Password ไม่ถูกต้อง กรุณาเช็คอีกรอบ'
            ], 400);
        }
    }

    public function submitLogout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
