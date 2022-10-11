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
        ])->givePermissionTo(['attendance_manage','make_attendance','attendance_report','student_list',
            'student_profile','batches_manage','subject_manage','announcement_manage','announcement_show',
            'announcement_create','announcement_edit','announcement_delete','classRooms_manage',
            'classRooms_create','classRooms_show','classRooms_edit','classRooms_delete','attendance_manage',
            'resources_list','upload_resource','upload_delete','teacher_list','teacher_profile']);
        Role::updateOrCreate([
            'id' => 3,
            'name' => 'Student',
            'guard_name' => 'web',
        ])->givePermissionTO(['attendance_manage','make_attendance','attendance_report','student_list','student_profile',
            'student_edit','batches_manage','subject_manage','announcement_manage','announcement_show',
            'announcement_create','announcement_edit','announcement_delete','classRooms_manage','classRooms_create',
            'classRooms_show','classRooms_edit','classRooms_delete','teacher_list','teacher_profile','']);
    }
}
