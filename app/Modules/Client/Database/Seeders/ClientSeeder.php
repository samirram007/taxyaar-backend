<?php

namespace App\Modules\Client\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Client\Models\Client;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::create(['name' => 'Sample Client']);

        // Uncomment to use factory if available
        // Client::factory()->count(10)->create();
    }
}
