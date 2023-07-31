<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'role_id' => 2,
                'menu_id' => 1
            ],
            [
                'role_id' => 2,
                'menu_id' => 2
            ],
            [
                'role_id' => 2,
                'menu_id' => 3
            ],
            [
                'role_id' => 2,
                'menu_id' => 4
            ],
            [
                'role_id' => 2,
                'menu_id' => 5
            ],
            [
                'role_id' => 2,
                'menu_id' => 6
            ],
            [
                'role_id' => 2,
                'menu_id' => 7
            ],
            [
                'role_id' => 2,
                'menu_id' => 8
            ]
        ];

        $count = RolePermission::where('id', '>', '1')->count();

        if(!$count){
            RolePermission::insert($items);
        }
    }
}
