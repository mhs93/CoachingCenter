<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Batch::factory(15)->create();
        Subject::factory(8)->create();

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeed::class,
//            ModelRoleSeeder::class,
        ]);
    }
}
