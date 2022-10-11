<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $module = Module::updateOrCreate(['name' => 'Student Manage']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Student List',
            'name' => 'student_list',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Register Student',
            'name' => 'register_student',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Student Profile',
            'name' => 'student_profile',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Student Edit',
            'name' => 'student_edit',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Student Delete',
            'name' => 'student_delete',
            'guard_name' => 'web',
        ]);


        $module = Module::updateOrCreate(['name' => 'Batches Manage']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Batches Manage',
            'name' => 'batches_manage',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Batches Create',
            'name' => 'batches_create',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Batches Edit',
            'name' => 'batches_edit',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Batches Delete',
            'name' => 'batches_delete',
            'guard_name' => 'web',
        ]);


        $module = Module::updateOrCreate(['name' => 'Subject Manage']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Subject Manage',
            'name' => 'subject_manage',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Subject Create',
            'name' => 'subject_create',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Subject Show',
            'name' => 'subject_show',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Subject Edit',
            'name' => 'subject_edit',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Subject Delete',
            'name' => 'subject_delete',
            'guard_name' => 'web',
        ]);


        $module = Module::updateOrCreate(['name' => 'Announcement Manage']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Announcement Manage',
            'name' => 'announcement_manage',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Announcement Show',
            'name' => 'announcement_show',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Announcement Create',
            'name' => 'announcement_create',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Announcement Edit',
            'name' => 'announcement_edit',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Announcement Delete',
            'name' => 'announcement_delete',
            'guard_name' => 'web',
        ]);

        $module = Module::updateOrCreate(['name' => 'ClassRooms Manage']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'ClassRooms Manage',
            'name' => 'classRooms_manage',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'ClassRooms Create',
            'name' => 'classRooms_create',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'ClassRooms Show',
            'name' => 'classRooms_show',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'ClassRooms Edit',
            'name' => 'classRooms_edit',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'ClassRooms Delete',
            'name' => 'classRooms_delete',
            'guard_name' => 'web',
        ]);
        $module = Module::updateOrCreate(['name' => 'Attendance Manage']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Attendance Manage',
            'name' => 'attendance_manage',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Make Attendance',
            'name' => 'make_attendance',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Attendance Report',
            'name' => 'attendance_report',
            'guard_name' => 'web',
        ]);


        $module = Module::updateOrCreate(['name' => 'Payment Manage']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Payment Manage',
            'name' => 'payment_manage',
            'guard_name' => 'web',
        ]);

        $module = Module::updateOrCreate(['name' => 'Resources Manage']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Resources List',
            'name' => 'resources_list',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Upload Resource',
            'name' => 'upload_resource',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Upload Delete',
            'name' => 'upload_delete',
            'guard_name' => 'web',
        ]);


        $module = Module::updateOrCreate(['name' => 'Teacher Manage']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Teacher List',
            'name' => 'teacher_list',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Teacher Register',
            'name' => 'teacher_register',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Teacher Profile',
            'name' => 'teacher_profile',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Teacher Edit',
            'name' => 'teacher_edit',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Teacher Delete',
            'name' => 'teacher_delete',
            'guard_name' => 'web',
        ]);

    }
}
