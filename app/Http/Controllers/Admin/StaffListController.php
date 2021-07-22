<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\BackEnd\Setting\FunctionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
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
                    return '<i class="fas fa-user mr-1 ml-1 text-secondary"></i> | '.$data->fname.' '.$data->lname;
                }
            })
            ->editColumn('updated_at', function($data) {
                if ($data->last_active == null) {
                    return '<span class="text-danger font-w500">'.__('staff_list.no_history_online').'</span>';
                }else {
                    return Carbon::parse($data->last_active)->format('d/m/Y H:i:s');
                }
            })
            ->editColumn('roles', function($data) {
                if ($data->roles == 'admin') {
                    return '<span class="badge badge-pill badge-primary">'.__('general.admin').'</span>';
                }else {
                    return '<span class="badge badge-pill badge-success">'.__('general.user').'</span>';
                }
            })
            ->editColumn('last_active', function($data) {
                if ($data->last_active == null) {
                    return '<span class="badge badge-pill badge-danger">'.__('staff_list.offline').'</span>';
                }else {
                    $date_last_active = Carbon::parse($data->last_active)->locale('th');
                    if ($date_last_active->diffInMinutes(Carbon::now()) <= '5') {
                        $last_active = '<span class="badge badge-pill badge-success">'.__('staff_list.online').'</span>';
                    }else {
                        $last_active = '<span class="badge badge-pill badge-danger">'.__('staff_list.offline').'</span>';
                    }
                    return $last_active;
                }
            })
            ->editColumn('language', function ($data) {
                if ($data->language == 'th') {
                    return '<img width="30" src="'.asset(Storage::url('assets/static/image/th.png')).'"> '.__('general.thai');
                }else {
                    return '<img width="30" src="'.asset(Storage::url('assets/static/image/en.png')).'"> '.__('general.english');
                }
            })
            ->addColumn('action', function ($data) {
                $attrData = "data-user_id='$data->user_id' ";
                $btnOption = '<button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-tools mr-1"></i>'.__('general.tool').'</button>';
                $btnOption .= '<div class="dropdown-menu font-size-sm" aria-labelledby="dropdown-default-outline-secondary">';
                // รายการเครื่องมือ
                $btnOption .= '<a class="dropdown-item" '.$attrData.' onclick="openModalEdit(this)" href="javascript:void(0)"><i class="fas fa-edit mr-1"></i>'.__('general.edit').'</a>';
                if (Auth::user()->roles == 'admin' && Auth::user()->user_id == $data->user_id || $data->roles == 'user') {
                    $btnOption .= '<a class="dropdown-item" '.$attrData.' onclick="openModalChangePassword(this)" href="javascript:void(0)"><i class="fas fa-key mr-1"></i>'.__('general.change_password').'</a>';
                }
                $btnOption .= '<a class="dropdown-item" '.$attrData.' onclick="openModalDelete(this)" href="javascript:void(0)"><i class="fas fa-trash mr-1"></i>'.__('general.delete').'</a>';

                $btnOption .= '</div>';

                return $btnOption;
            })
            ->rawColumns(['full_name', 'roles', 'updated_at', 'last_active', 'language', 'action'])
            ->make(true);
    }

    public function submitChangePassword(Request $request)
    {
        $rules = [
            'user_id' => 'required|numeric',
            'password' => 'required|min:8|confirmed'
        ];

        $customMessages = [
            'required' => __('general.data_not_found').' :attribute',
            'min' => __('general.need_more').' :min '.__('general.character'),
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

        user::where('user_id', $request->user_id)->update([
            'password' => Hash::make($request->password),
            'password_plain_text' => $request->password
        ]);

        return response()->json([
            'message' => __('staff_list.password_change_success')
        ], 200); 
    }

    public function getUserDataId(Request $request)
    {
        $rules = [
            'user_id' => 'required|numeric'
        ];

        $customMessages = [
            'required' => __('general.data_not_found').' :attribute',
            'numeric' => ':attribute '.__('general.data_number_only')
        ];

        $validation = Validator::make($request->all(), $rules, $customMessages);
        if ($validation->fails()) {
            return response()->json([
                'message' => __('general.parameter_not_found'),
                'error' => $validation->errors()
            ], 400); 
        }
        if (Auth::user()->user_id == $request->user_id) {
            $data = user::where('user_id', $request->user_id)->first();
        }else {
            $data = user::where('user_id', $request->user_id)->first()->makeHidden('password_plain_text');
        }

        return response()->json([
            'message' => __('staff_list.data_extraction_success'),
            'data' => $data
        ], 200); 
    }

    public function submitEdit(Request $request)
    {
        $rules = [
            'user_id' => 'required|numeric',
            'fname' => 'required',
            'lname' => 'required',
            'department_id' => 'required|numeric',
            'email' => 'required',
            'roles' => 'required',
            'language' => 'required'
        ];

        $customMessages = [
            'required' => __('general.data_not_found').' :attribute',
            'numeric' => ':attribute '.__('general.data_number_only')
        ];

        $validation = Validator::make($request->all(), $rules, $customMessages);
        if ($validation->fails()) {
            return response()->json([
                'message' => __('general.parameter_not_found'),
                'error' => $validation->errors()
            ], 400); 
        }

        user::where('user_id', $request->user_id)->update([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'department_id' => $request->department_id,
            'email' => $request->email,
            'roles' => $request->roles,
            'language' => $request->language
        ]);

        $reloadPage = Auth::user()->user_id == $request->user_id ? true : false;

        return response()->json([
            'message' => __('staff_list.data_update_success'),
            'reloadPage' => $reloadPage
        ], 200); 
    }

    public function submitDelete(Request $request)
    {
        $rules = [
            'user_id' => 'required|numeric'
        ];

        $customMessages = [
            'required' => __('general.data_not_found').' :attribute',
            'numeric' => ':attribute '.__('general.data_number_only')
        ];

        $validation = Validator::make($request->all(), $rules, $customMessages);
        if ($validation->fails()) {
            return response()->json([
                'message' => __('general.parameter_not_found'),
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
            'message' => __('staff_list.delete_data_success')
        ], 200); 
    }

}