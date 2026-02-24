<?php

namespace App\Modules\TopicCategory\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\TopicCategory\Models\TopicCategory;

class TopicCategorySeeder extends Seeder
{
    public function run(): void
    {
        // TopicCategory::create([
        //     'name' => 'Sample TopicCategory',
        //     'slug' => 'category_one',
        //     'description' => 'Sample TopicCategory Description',
        //     'status' => 'active',
        // ]);

        // Uncomment to use factory if available
        // TopicCategory::factory()->count(10)->create();
    }
}
