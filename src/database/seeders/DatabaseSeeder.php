<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run():void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin9999'),
            'is_admin' => 1,
        ]) ;
        if (app()->isLocal()){
            User::factory()
            ->count(10)
            ->sequence(function ($sequence) {
                return [
                    'name' => sprintf('user_%02d', $sequence->index + 1),
                    'email' => sprintf('user_%02d@example.com', $sequence->index + 1),
                    'password' => Hash::make(sprintf('user_%02d_password', $sequence->index + 1)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })
            ->create();
        }
    }
}
