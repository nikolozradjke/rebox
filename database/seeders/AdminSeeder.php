<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_count = User::where('personal_id', '01234567890')->exists();

        if(!$admin_count)
        User::create([
            'first_name' => 'მთავარი',
            'last_name' => 'ადმინისტრატორი',
            'personal_id' => '01234567890',
            'citizenship' => 'საქართველო',
            'password' => Hash::make('Admini!@#'),
            'role' => 2
        ]);
    }
}
