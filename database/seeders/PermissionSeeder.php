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
        $module = Module::updateOrCreate(['name' => 'Subject']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Subject List',
            'name' => 'subject_list',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Subject Modify',
            'name' => 'subject_modify',
            'guard_name' => 'web',
        ]);

        $module = Module::updateOrCreate(['name' => 'Batches']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Batches List',
            'name' => 'batches_list',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Batches Modify',
            'name' => 'batches_modify',
            'guard_name' => 'web',
        ]);

        $module = Module::updateOrCreate(['name' => 'Student']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Student List',
            'name' => 'student_list',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Student Modify',
            'name' => 'student_modify',
            'guard_name' => 'web',
        ]);

        $module = Module::updateOrCreate(['name' => 'Teacher']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Teachers List',
            'name' => 'teacher_list',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Teacher Modify',
            'name' => 'teacher_modify',
            'guard_name' => 'web',
        ]);


        $module = Module::updateOrCreate(['name' => 'Announcement']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Announcement List',
            'name' => 'announcement_list',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Announcement Modify',
            'name' => 'announcement_modify',
            'guard_name' => 'web',
        ]);

        $module = Module::updateOrCreate(['name' => 'Special Class']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Special Class List',
            'name' => 'specialClass_list',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Special Class Modify',
            'name' => 'specialClass_modify',
            'guard_name' => 'web',
        ]);


        $module = Module::updateOrCreate(['name' => 'Attendance']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Attendance Manage',
            'name' => 'attendance_manage',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Student Attendance',
            'name' => 'student_attendance',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Teacher Attendance',
            'name' => 'teacher_attendance',
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
            'title' => 'Payment List Teacher',
            'name' => 'payment_list_teacher',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Payment List Student',
            'name' => 'payment_list_student',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Payment Manage',
            'name' => 'payment_manage',
            'guard_name' => 'web',
        ]);

        $module = Module::updateOrCreate(['name' => 'Resource']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Resources List',
            'name' => 'resources_list',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Resource Upload',
            'name' => 'resource_upload',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Resource Manage',
            'name' => 'resource_manage',
            'guard_name' => 'web',
        ]);


        // Exam
        $module = Module::updateOrCreate(['name' => 'Exam']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Exam List',
            'name' => 'exam_list',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Exam Modify',
            'name' => 'exam_modify',
            'guard_name' => 'web',
        ]);

        // Mark
        $module = Module::updateOrCreate(['name' => 'Mark Manage']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Mark List',
            'name' => 'mark_list',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Mark Modify',
            'name' => 'mark_modify',
            'guard_name' => 'web',
        ]);

        $module = Module::updateOrCreate(['name' => 'Class Routine']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Routine List',
            'name' => 'routine_list',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Routine Modify',
            'name' => 'routine_modify',
            'guard_name' => 'web',
        ]);

        $module = Module::updateOrCreate(['name' => 'Account Manage']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Account Manage',
            'name' => 'account_manage',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Account List',
            'name' => 'account_list',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Student Payment',
            'name' => 'student_payment',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Teacher Payment',
            'name' => 'teacher_payment',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Income Manage',
            'name' => 'income_manage',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Expense Manage',
            'name' => 'expense_manage',
            'guard_name' => 'web',
        ]);

        $module = Module::updateOrCreate(['name' => 'Report Manage']);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Report Manage',
            'name' => 'report_manage',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Students Report',
            'name' => 'student_report',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Students Transaction Report',
            'name' => 'student_transaction_report',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Teachers Report',
            'name' => 'teacher_report',
            'guard_name' => 'web',
        ]);
        Permission::updateOrCreate([
            'module_id' => $module->id,
            'title' => 'Teachers Transaction Report',
            'name' => 'teacher_transaction_report',
            'guard_name' => 'web',
        ]);

    }
}
