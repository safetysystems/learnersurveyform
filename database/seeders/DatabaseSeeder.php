<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'lonard@safetysystems.net.au'],
            [
                'name' => 'Admin',
                'password' => '071914Akbt',
            ]
        );

        $this->call([
            AboutYourTrainingQuestionsSeeder::class,
        ]);
    }
}
