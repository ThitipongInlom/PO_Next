<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\user;
use App\Models\department;

class SystemDefault extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // สร้าง User เริ่มต้น
        SystemDefault::createUser();
        // สร้าง department เริ่มต้น
        SystemDefault::createDepartment();
    }

    public function createUser()
    {
        DB::table('users')->insert([
            [
                'fname' => 'Thitipong',
                'lname' => 'Inlom',
                'department_id' => '1',
                'language' => 'th',
                'username' => 'nice',
                'password' => Hash::make('nice'),
                'password_plain_text' => 'nice',
                'roles' => 'admin'
            ],
            [
                'fname' => 'Admin',
                'lname' => 'TEST',
                'department_id' => '1',
                'language' => 'th',
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'password_plain_text' => 'admin',
                'roles' => 'admin'   
            ],
            [
                'fname' => 'User',
                'lname' => 'TEST',
                'department_id' => '1',
                'language' => 'th',
                'username' => 'user',
                'password' => Hash::make('user'),
                'password_plain_text' => 'user',
                'roles' => 'user'
            ]
        ]);
    }

    public function createDepartment()
    {
        DB::table('departments')->insert([
            [
                'department_code' => 'IT',
                'department_name_th' => 'เทคโนโลยีสารสนเทศ',
                'department_name_en' => 'Information Technology'
            ],
            [
                'department_code' => 'HR',
                'department_name_th' => 'ฝ่ายบุคคล',
                'department_name_en' => 'Human Resource'
            ],
        ]);
    }
}
