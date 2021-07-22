<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\BackEnd\Setting\FunctionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\user;
use App\Models\department;

class StaffListController extends Controller
{
    public function pageStaffList(Request $request)
    {
        $department = department::where('status', '1')->where('is_deleted', '1')->get();
        
        return view('admin/staff_list', [
            'department' => $department
        ]);
    }

    public static function getStaffListTable($request)
    {
        $data = user::where('is_deleted', '1')->orderBy('user_id', 'asc');
        return Datatables::of($data)
            ->addColumn('full_name', function($data) {
                if ($data->roles == 'admin') {
                    return '<i class="fas fa-crown mr-1 text-primary"></i> | '.$data->fname.' '.$data->lname;
                }else {
                    return '<i class="fas fa-user mr-1 text-secondary"></i> | '.$data->fname.' '.$data->lname;
                }
            })
            ->editColumn('updated_at', function($data) {
                return Carbon::parse($data->updated_at)->format('d/m/Y H:i:s');
            })
            ->editColumn('roles', function($data) {
                if ($data->roles == 'admin') {
                    return '<span class="badge badge-pill badge-primary">Admin</span>';
                }else {
                    return '<span class="badge badge-pill badge-success">User</span>';
                }
            })
            ->editColumn('last_active', function($data) {
                if ($data->last_active == null) {
                    return '<span class="badge badge-pill badge-danger">ออฟไลน์</span>';
                }else {
                    $date_last_active = Carbon::parse($data->last_active)->locale('th');
                    if ($date_last_active->diffInMinutes(Carbon::now()) <= '5') {
                        $last_active = '<span class="badge badge-pill badge-success">ออนไลน์</span>';
                    }else {
                        $last_active = '<span class="badge badge-pill badge-danger">ออฟไลน์</span>';
                    }
                    return $last_active;
                }
            })
            ->addColumn('action', function ($data) {
                $attrData = "data-user_id='$data->user_id' ";
                $btnOption = '<button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-tools"></i> เครื่องมือ</button>';
                $btnOption .= '<div class="dropdown-menu font-size-sm" aria-labelledby="dropdown-default-outline-secondary">';
                // แก้ไข
                if (Auth::user()->roles == 'admin' && Auth::user()->user_id == $data->user_id || $data->roles == 'admin') {
                    // $btnOption .= '<a class="dropdown-item" '.$attrData.' onclick="openModalChangePassword(this)" href="javascript:void(0)"><i class="fas fa-key mr-1"></i>เปลี่ยนพาส</a>';
                }
                // $btnOption .= '<a class="dropdown-item" '.$attrData.' onclick="openModalEdit(this)" href="javascript:void(0)"><i class="fas fa-edit mr-1"></i>แก้ไข</a>';
                $btnOption .= '<a class="dropdown-item" '.$attrData.' onclick="openModalDelete(this)" href="javascript:void(0)"><i class="fas fa-trash mr-1"></i> ลบ</a>';

                $btnOption .= '</div>';

                return $btnOption;
            })
            ->rawColumns(['full_name', 'roles', 'last_active', 'action'])
            ->make(true);
    }

    public function submitChangePassword(Request $request)
    {
        $rules = [
            'user_id' => 'required|numeric',
            'password' => 'required|min:8|confirmed'
        ];

        $customMessages = [
            'required' => 'ไม่พบข้อมูล :attribute',
            'min' => 'รหัสผ่านต้องมากกว่า :min ตัวอักษร',
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

        user::where('user_id', $request->user_id)->update([
            'password' => Hash::make($request->password),
            'password_plain_text' => $request->password
        ]);

        return response()->json([
            'message' => 'เปลี่ยนรหัสผ่านสำเร็จ'
        ], 200); 
    }

    public function getUserDataId(Request $request)
    {
        $rules = [
            'user_id' => 'required|numeric'
        ];

        $customMessages = [
            'required' => 'ไม่พบข้อมูล :attribute',
            'numeric' => ':attribute ข้อมูลใช้ได้แค่ตัวเลข'
        ];

        $validation = Validator::make($request->all(), $rules, $customMessages);
        if ($validation->fails()) {
            return response()->json([
                'message' => 'เกิดข้อผิดพลาดในการส่งข้อมูลไม่ครบตามที่กำหนดไว้',
                'error' => $validation->errors()
            ], 400); 
        }

        $data = user::where('user_id', $request->user_id)->first()->makeHidden('password_plain_text');

        return response()->json([
            'message' => 'ดึงข้อมูลสำเร็จ',
            'data' => $data
        ], 200); 
    }

    public function submitEdit(Request $request)
    {
        $rules = [
            'user_id' => 'required|numeric',
            'staff_name' => 'required',
            'status' => 'required|numeric',
            'permission' => 'required|numeric'
        ];

        $customMessages = [
            'required' => 'ไม่พบข้อมูล :attribute',
            'numeric' => ':attribute ข้อมูลใช้ได้แค่ตัวเลข'
        ];

        $validation = Validator::make($request->all(), $rules, $customMessages);
        if ($validation->fails()) {
            return response()->json([
                'message' => 'เกิดข้อผิดพลาดในการส่งข้อมูลไม่ครบตามที่กำหนดไว้',
                'error' => $validation->errors()
            ], 400); 
        }

        user::where('user_id', $request->user_id)->update([
            'staff_name' => $request->staff_name,
            'status' => $request->status,
            'permission' => $request->permission
        ]);

        return response()->json([
            'message' => 'อัพเดตข้อมูลสำเร็จ'
        ], 200); 
    }

    public function submitDelete(Request $request)
    {
        $rules = [
            'user_id' => 'required|numeric'
        ];

        $customMessages = [
            'required' => 'ไม่พบข้อมูล :attribute',
            'numeric' => ':attribute ข้อมูลใช้ได้แค่ตัวเลข'
        ];

        $validation = Validator::make($request->all(), $rules, $customMessages);
        if ($validation->fails()) {
            return response()->json([
                'message' => 'เกิดข้อผิดพลาดในการส่งข้อมูลไม่ครบตามที่กำหนดไว้',
                'error' => $validation->errors()
            ], 400); 
        }
        // อัพเดต ข้อมูลที่ ลบ
        user::where('user_id', $request->user_id)->update([
            'is_deleted' => '0',
            'by_deleted' => Auth::user()->user_id,
            'date_deleted' => Carbon::now()
        ]);

        return response()->json([
            'message' => 'ลบข้อมูลสำเร็จ'
        ], 200); 
    }

}