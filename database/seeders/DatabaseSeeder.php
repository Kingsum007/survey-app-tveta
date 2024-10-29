<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Safi Ullah Mirzai',
            'email' => 'sumirzai@gmail.com',
            'role' => 'Admin',
            'created_at' => \Carbon\Carbon::createFromDate(now())->toDateTimeString(),
             'password' => Hash::make('12341234'),
        ]);
    }
}
