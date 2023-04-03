<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'client_create',
            ],
            [
                'id'    => 18,
                'title' => 'client_edit',
            ],
            [
                'id'    => 19,
                'title' => 'client_show',
            ],
            [
                'id'    => 20,
                'title' => 'client_delete',
            ],
            [
                'id'    => 21,
                'title' => 'client_access',
            ],
            [
                'id'    => 22,
                'title' => 'bus_create',
            ],
            [
                'id'    => 23,
                'title' => 'bus_edit',
            ],
            [
                'id'    => 24,
                'title' => 'bus_show',
            ],
            [
                'id'    => 25,
                'title' => 'bus_delete',
            ],
            [
                'id'    => 26,
                'title' => 'bus_access',
            ],
            [
                'id'    => 27,
                'title' => 'bus_station_create',
            ],
            [
                'id'    => 28,
                'title' => 'bus_station_edit',
            ],
            [
                'id'    => 29,
                'title' => 'bus_station_show',
            ],
            [
                'id'    => 30,
                'title' => 'bus_station_delete',
            ],
            [
                'id'    => 31,
                'title' => 'bus_station_access',
            ],
            [
                'id'    => 32,
                'title' => 'class_room_create',
            ],
            [
                'id'    => 33,
                'title' => 'class_room_edit',
            ],
            [
                'id'    => 34,
                'title' => 'class_room_show',
            ],
            [
                'id'    => 35,
                'title' => 'class_room_delete',
            ],
            [
                'id'    => 36,
                'title' => 'class_room_access',
            ],
            [
                'id'    => 37,
                'title' => 'class_section_create',
            ],
            [
                'id'    => 38,
                'title' => 'class_section_edit',
            ],
            [
                'id'    => 39,
                'title' => 'class_section_show',
            ],
            [
                'id'    => 40,
                'title' => 'class_section_delete',
            ],
            [
                'id'    => 41,
                'title' => 'class_section_access',
            ],
            [
                'id'    => 42,
                'title' => 'homework_create',
            ],
            [
                'id'    => 43,
                'title' => 'homework_edit',
            ],
            [
                'id'    => 44,
                'title' => 'homework_show',
            ],
            [
                'id'    => 45,
                'title' => 'homework_delete',
            ],
            [
                'id'    => 46,
                'title' => 'homework_access',
            ],
            [
                'id'    => 47,
                'title' => 'homework_solution_create',
            ],
            [
                'id'    => 48,
                'title' => 'homework_solution_edit',
            ],
            [
                'id'    => 49,
                'title' => 'homework_solution_show',
            ],
            [
                'id'    => 50,
                'title' => 'homework_solution_delete',
            ],
            [
                'id'    => 51,
                'title' => 'homework_solution_access',
            ],
            [
                'id'    => 52,
                'title' => 'message_create',
            ],
            [
                'id'    => 53,
                'title' => 'message_edit',
            ],
            [
                'id'    => 54,
                'title' => 'message_show',
            ],
            [
                'id'    => 55,
                'title' => 'message_delete',
            ],
            [
                'id'    => 56,
                'title' => 'message_access',
            ],
            [
                'id'    => 57,
                'title' => 'attendance_create',
            ],
            [
                'id'    => 58,
                'title' => 'attendance_edit',
            ],
            [
                'id'    => 59,
                'title' => 'attendance_show',
            ],
            [
                'id'    => 60,
                'title' => 'attendance_delete',
            ],
            [
                'id'    => 61,
                'title' => 'attendance_access',
            ],
            [
                'id'    => 62,
                'title' => 'student_attendance_create',
            ],
            [
                'id'    => 63,
                'title' => 'student_attendance_edit',
            ],
            [
                'id'    => 64,
                'title' => 'student_attendance_show',
            ],
            [
                'id'    => 65,
                'title' => 'student_attendance_delete',
            ],
            [
                'id'    => 66,
                'title' => 'student_attendance_access',
            ],
            [
                'id'    => 67,
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => 68,
                'title' => 'check_station_create',
            ],
            [
                'id'    => 69,
                'title' => 'check_station_edit',
            ],
            [
                'id'    => 70,
                'title' => 'check_station_show',
            ],
            [
                'id'    => 71,
                'title' => 'check_station_delete',
            ],
            [
                'id'    => 72,
                'title' => 'check_station_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
