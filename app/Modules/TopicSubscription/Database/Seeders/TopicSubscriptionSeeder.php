<?php

namespace App\Modules\TopicSubscription\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\TopicSubscription\Models\TopicSubscription;

class TopicSubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        TopicSubscription::create(['name' => 'Sample TopicSubscription']);

        // Uncomment to use factory if available
        // TopicSubscription::factory()->count(10)->create();
    }
}
