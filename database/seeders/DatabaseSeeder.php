<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Batch;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Subject::factory(8)->create();
        //Batch::factory(5)->create();
        //Student::factory(8)->create();
        //Teacher::factory(8)->create();
        //Exam::factory(8)->create();
        //Mark::factory(8)->create();

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeed::class,
            AccountSeeder::class,
//            ModelRoleSeeder::class,
        ]);
    }
}
