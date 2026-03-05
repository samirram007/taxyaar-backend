<?php

namespace App\Modules\Assessee\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Assessee\Models\Assessee;

class AssesseeSeeder extends Seeder
{
    public function run(): void
    {
        Assessee::create(['name' => 'Sample Assessee']);

        // Uncomment to use factory if available
        // Assessee::factory()->count(10)->create();
    }
}
