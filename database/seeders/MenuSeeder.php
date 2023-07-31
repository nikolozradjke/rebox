<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'title' => 'მოთხოვნები',
                'path' => 'requests'
            ],
            [
                'title' => 'განათლების პროგრამები',
                'path' => 'edu-program'
            ],
            [
                'title' => 'დასაქმების პროგრამები',
                'path' => 'emp-program'
            ],
            [
                'title' => 'იდეები და შეთავაზებები',
                'path' => 'ideas'
            ],
            [
                'title' => 'მომხმარებელთა მართვა',
                'path' => 'users'
            ],
            [
                'title' => 'როლები',
                'path' => 'roles'
            ],
            [
                'title' => 'დაწესებულებები',
                'path' => 'institutions'
            ],
            [
                'title' => 'კატეგორიები',
                'path' => 'categories'
            ]
        ];

        $count = Menu::where('id', '>', '1')->count();

        if(!$count){
            Menu::insert($items);
        }
    }
}
