<?php

namespace App\Modules\UserFollows\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\UserFollows\Models\UserFollows;

class UserFollowsSeeder extends Seeder
{
    public function run(): void
    {
        UserFollows::create(['name' => 'Sample UserFollows']);

        // Uncomment to use factory if available
        // UserFollows::factory()->count(10)->create();
    }
}
