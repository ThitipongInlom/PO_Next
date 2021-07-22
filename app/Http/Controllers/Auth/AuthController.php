<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
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
        $urlImageBackgroundIogin = asset(Storage::url("assets/static/image/background_login.jpg"));

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
            if (Auth::user()->is_deleted == '0') {
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

    public function submitRegister(Request $request)
    {
        $rules = [
            'fname' => 'required',
            'lname' => 'required',
            'department_id' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'roles' => 'required'
        ];

        $customMessages = [
            'required' => 'ไม่พบข้อมูล :attribute',
            'confirmed' => 'กรุณากรอก :attribute ให้เหมือนกัน',
            'numeric' => ':attribute ข้อมูลใช้ได้แค่ตัวเลข'
        ];

        $validation = Validator::make($request->all(), $rules, $customMessages);
        if ($validation->fails()) {
            return response()->json([
                'message' => 'เกิดข้อผิดพลาดในการส่งข้อมูลไม่ครบตามที่กำหนดไว้',
                'error' => $validation->errors()
            ], 400); 
        }
        // เช็คว่ามีในระบบแล้วหรือไม่
        $counUser = user::where('username', $request->username)->count();
        if ($counUser == '1' || $counUser > '1') {
            return response()->json([
                'message' => 'Username นี้มีในระบบแล้ว กรุณา ใช้ Username อื่น'
            ], 400); 
        }
        // สร้าง User
        user::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'department_id' => $request->department_id,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'password_plain_text' => $request->password,
            'roles' => $request->roles,
            'last_active' => Carbon::now()
        ]);

        return response()->json([
            'message' => 'สร้าง User สำเร็จ'
        ], 200); 
    }

    public function submitLogout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
