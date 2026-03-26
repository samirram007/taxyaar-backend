<?php

namespace App\Modules\SLAPolicyRule\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\SLAPolicyRule\Models\SLAPolicyRule;

class SLAPolicyRuleSeeder extends Seeder
{
    public function run(): void
    {
        SLAPolicyRule::create(['name' => 'Sample SLAPolicyRule']);

        // Uncomment to use factory if available
        // SLAPolicyRule::factory()->count(10)->create();
    }
}
