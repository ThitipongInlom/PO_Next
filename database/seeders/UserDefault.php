<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\user;

class UserDefault extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // สร้าง Nice ทดสอบ
        user::create([
            'fname' => 'Thitipong',
            'lname' => 'Inlom',
            'username' => 'nice',
            'password' => Hash::make('nice'),
            'password_plain_text' => 'nice',
            'roles' => 'admin'
        ]);
    }
}
