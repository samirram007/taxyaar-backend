<?php

namespace App\Modules\ArticleComments\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\ArticleComments\Models\ArticleComments;

class ArticleCommentsSeeder extends Seeder
{
    public function run(): void
    {
        ArticleComments::create(['name' => 'Sample ArticleComments']);

        // Uncomment to use factory if available
        // ArticleComments::factory()->count(10)->create();
    }
}
