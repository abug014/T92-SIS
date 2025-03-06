<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Update existing users
        DB::table('users')
            ->where('email', 'admin@gmail.com')
            ->update(['is_admin' => true]);

        DB::table('users')
            ->where('email', 'test@gmail.com')
            ->update(['is_admin' => false]);

        // Run the student seeder
        $this->call([
            StudentSeeder::class,
        ]);
    }
}
