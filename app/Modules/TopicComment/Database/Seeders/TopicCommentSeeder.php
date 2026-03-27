<?php

namespace App\Modules\TopicComment\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\TopicComment\Models\TopicComment;

class TopicCommentSeeder extends Seeder
{
    public function run(): void
    {
        TopicComment::create(['name' => 'Sample TopicComment']);

        // Uncomment to use factory if available
        // TopicComment::factory()->count(10)->create();
    }
}
