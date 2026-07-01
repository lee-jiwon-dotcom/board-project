<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
         Category::create(['name' => '夕焼け', 'slug' => 'sunset']);
         Category::create(['name' => '人物', 'slug' => 'people']);
    }
}
