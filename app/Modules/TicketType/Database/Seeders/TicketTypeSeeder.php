<?php

namespace App\Modules\TicketType\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\TicketType\Models\TicketType;

class TicketTypeSeeder extends Seeder
{
    public function run(): void
    {
        TicketType::create(['name' => 'Sample TicketType']);

        // Uncomment to use factory if available
        // TicketType::factory()->count(10)->create();
    }
}
