<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'title' => 'ბენეფიციარი'
            ],
            [
                'title' => 'ადმინისტრატორი'
            ],
            [
                'title' => 'განათლების პროგრამის მენეჯერი'
            ],
            [
                'title' => 'დასაქმების პროგრამის მენეჯერი'
            ],
            [
                'title' => 'იდეებისა და შეთავაზებების მენეჯერი'
            ]
        ];

        $count = Role::where('id', '>', '1')->count();

        if(!$count){
            Role::insert($items);
        }
    }
}
