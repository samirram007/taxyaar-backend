<?php

namespace App\Modules\EriSignature\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\EriSignature\Models\EriSignature;

class EriSignatureSeeder extends Seeder
{
    public function run(): void
    {
        EriSignature::create(['name' => 'Sample EriSignature']);

        // Uncomment to use factory if available
        // EriSignature::factory()->count(10)->create();
    }
}
