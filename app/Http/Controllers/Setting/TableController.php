<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\StaffListController;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function getSwithDataTable(Request $request)
    {
        // เช็คว่ามีการส่งข้อมูลมาหรือไม่
        if (empty($request->action)) {
            return response()->json([
                'message' => 'ไม่สามารถดึงข้อมูลได้'
            ], 400); 
        }
        // เข้าเงื่อนไขต่างๆ
        if ($request->action == 'Staff_List') {
            return StaffListController::getStaffListTable($request);
        }else {
            return response()->json([
                'message' => 'ไม่พบ URL ในการดึง Table'
            ], 400); 
        }
    }
}