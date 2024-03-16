<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
           'name_EN' => 'Apartments',
           'name_AR' => 'شقق'
        ]);
        Category::create([
            'name_EN' => 'Offices',
            'name_AR' => 'مكاتب'
        ]);
        Category::create([
            'name_EN' => 'Clinics',
            'name_AR' => 'عيادات'
        ]);
        Category::create([
            'name_EN' => 'Properties',
            'name_AR' => 'محلات'
        ]);

    }
}
