<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Setting\FunctionController;
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
            'required' => __('general.data_not_found').' :attribute'
        ];

        $validation = Validator::make($request->all(), $rules, $customMessages);
        if ($validation->fails()) {
            return response()->json([
                'message' => __('general.parameter_not_found'),
                'error' => $validation->errors()
            ], 400); 
        }
        
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // เช็คว่าถูก ให้เข้าใช้งานได้หรือไม่
            if (Auth::user()->is_deleted == '0') {
                Auth::logout();
                return response()->json([
                    'message' => __('login.username').' '.__('general.cant_access')
                ], 400);
            }
            // อัพเดต หลังจาก Login สำเร็จ
            user::where('user_id', Auth::user()->user_id)->update([
                'ip_address' => $request->ip(),
                'device' => $request->device,
                'last_active' => Carbon::now()
            ]);
            // ออกจากระบบ อัตโนมัติ
            Auth::logoutOtherDevices($request->password);

            return response()->json([
                'message' => __('login.login_success').' '.__('login.please_wait_a_moment')
            ], 200);
        }else{
            return response()->json([
                'message' => __('login.username').' '.__('general.or').' '.__('login.password').' '.__('general.incorrect').' '.__('general.please_check_again')
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
            'roles' => 'required',
            'language' => 'required'
        ];

        $customMessages = [
            'required' => __('general.data_not_found').' :attribute',
            'confirmed' => __('general.please_enter').' :attribute '.__('general.be_the_same'),
            'numeric' => ':attribute '.__('general.data_number_only')
        ];

        $validation = Validator::make($request->all(), $rules, $customMessages);
        if ($validation->fails()) {
            return response()->json([
                'message' => __('general.parameter_not_found'),
                'error' => $validation->errors()
            ], 400); 
        }
        // เช็คว่ามีในระบบแล้วหรือไม่
        $counUser = user::where('username', $request->username)->count();
        if ($counUser == '1' || $counUser > '1') {
            return response()->json([
                'message' => __('login.username').' '.__('general.already_exitsts_in_system').' '.__('general.please').' '.__('general.use').' '.__('login.username').' '.__('general.other')
            ], 400); 
        }
        // สร้าง User
        user::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'department_id' => $request->department_id,
            'email' => $request->email,
            'language' => $request->language,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'password_plain_text' => $request->password,
            'roles' => $request->roles,
            'last_active' => Carbon::now()
        ]);

        return response()->json([
            'message' => __('general.create').' '.__('login.username').' '.__('general.success')
        ], 200); 
    }

    public function submitLogout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
