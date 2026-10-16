<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(
            ['code' => 'visitor'],
            [
                'name' => 'Khách tham quan',
                'description' => 'Người sử dụng chức năng tham quan công khai.',
            ]
        );

        Role::updateOrCreate(
            ['code' => 'admin'],
            [
                'name' => 'Quản trị viên',
                'description' => 'Người quản lý nội dung và vận hành hệ thống.',
            ]
        );
    }
}
