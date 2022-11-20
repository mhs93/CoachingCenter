<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $giveAllPermission = Permission::all();
        Role::updateOrCreate([
            'id' => 1,
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ])->permissions()->sync($giveAllPermission->pluck('id'));
        Role::updateOrCreate([
            'id' => 2,
            'name' => 'Teacher',
            'guard_name' => 'web',
        ])->givePermissionTo(['attendance_manage','student_attendance','attendance_report','subject_list',
            'batches_manage','student_list','teacher_list','routine_list','routine_modify','attendance_manage',
            'student_attendance','attendance_report','exam_list','exam_modify','announcement_manage',
            'announcement_list','specialClass_list','specialClass_manage','resources_list','resource_upload',
            'resource_manage']);
        Role::updateOrCreate([
            'id' => 3,
            'name' => 'Student',
            'guard_name' => 'web',
        ])->givePermissionTO(['attendance_manage','attendance_report','subject_list','batches_manage',
            'student_list','teacher_list','routine_list','attendance_manage','attendance_report',
            'exam_list','announcement_list','specialClass_list','resources_list','resource_upload',
            ]);

        Role::updateOrCreate([
            'id' => 4,
            'name' => 'Accountant',
            'guard_name' => 'web',
        ])->givePermissionTO(['account_manage','account_list','student_payment','student_list',
            'teacher_list','teacher_payment','payment_manage','report_manage','student_transaction_report',
            'teacher_transaction_report']);
    }
}
