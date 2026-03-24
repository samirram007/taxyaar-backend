<?php

namespace App\Modules\SLAPolicy\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\SLAPolicy\Models\SLAPolicy;

class SLAPolicySeeder extends Seeder
{
    public function run(): void
    {
        SLAPolicy::create(['name' => 'Sample SLAPolicy']);

        // Uncomment to use factory if available
        // SLAPolicy::factory()->count(10)->create();
    }
}
