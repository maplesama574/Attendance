<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run():void
    {
        User::updateOrCreate(
          ['email' => 'admin@admin.com'],
            [
                'name' => '管理者',
                'password' => Hash::make('admin9999'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
